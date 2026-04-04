// This script provides the core payment calculator functions translated from React's paymentPlans.ts.
// It will be included within the @section('script') part of property_details.blade.php.

function addMonths(date, months) {
    var d = new Date(date);
    d.setMonth(d.getMonth() + months);
    return d;
}

function formatMonth(date) {
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var m = monthNames[date.getMonth()];
    var y = String(date.getFullYear()).slice(-2);
    return m + "-" + y;
}

function ordinal(n) {
    var s = ["th", "st", "nd", "rd"];
    var v = n % 100;
    return n + (s[(v - 20) % 10] || s[v] || s[0]);
}

function formatCurrency(amount) {
    var prefix = amount < 0 ? "-" : "";
    var abs = Math.abs(amount);
    return "QAR " + prefix + abs.toLocaleString("en-US", { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

function formatPercent(pct) {
    return pct.toFixed(2) + "%";
}

function buildRows(entries, fullPrice) {
    var cumulative = 0;
    return entries.map(function (e) {
        cumulative += e.payment;
        return Object.assign({}, e, {
            percentage: (e.payment / fullPrice) * 100,
            totalPayment: cumulative,
            totalPercentage: (cumulative / fullPrice) * 100,
            dueAmount: fullPrice - cumulative
        });
    });
}

function prependMgmtFeeRow(rows, fullPrice, managementFeeRate, startDate) {
    var managementFees = fullPrice * managementFeeRate;
    var feeLabel = managementFeeRate > 0
        ? ("Management Fees (" + (managementFeeRate * 100).toFixed(1) + "%)")
        : "Management Fees (Waived)";
    var mgmtRow = {
        label: feeLabel, // Can be localized later when mapping to blade
        month: formatMonth(startDate),
        payment: managementFees,
        percentage: (managementFees / fullPrice) * 100,
        totalPayment: 0,
        totalPercentage: 0,
        dueAmount: fullPrice,
        isHighlight: false,
        isMgmtFee: true
    };
    return [mgmtRow].concat(rows);
}

function scenario1(p, priceAfterDisc) {
    var count = p.totalDurationMonths || 71;
    var monthly = priceAfterDisc / count;
    var lastAdj = priceAfterDisc - monthly * (count - 1);
    var entries = [];
    for (var i = 0; i < count; i++) {
        entries.push({
            label: ordinal(i + 1) + " Installment",
            month: formatMonth(addMonths(p.startDate, i)),
            payment: i === count - 1 ? lastAdj : monthly
        });
    }
    return buildRows(entries, p.fullPrice);
}

function scenario2(p, priceAfterDisc) {
    var downPayment = 300000;
    var bumpMonths = [13, 25, 37, 49, 61];
    var installmentCount = 70;
    var bumpAmount = 58000;
    var regularAmount = 15000;

    var entries = [];
    entries.push({
        label: "Down Payment",
        month: formatMonth(p.startDate),
        payment: downPayment,
        isHighlight: true
    });

    for (var i = 1; i <= installmentCount; i++) {
        var date = addMonths(p.startDate, i);
        var isBump = bumpMonths.includes(i);
        var amount = isBump ? bumpAmount : regularAmount;
        var label = i === 8 ? ordinal(i) + " Installment (Hand over)" : ordinal(i) + " Installment";
        entries.push({
            label: label,
            month: formatMonth(date),
            payment: amount
        });
    }

    return buildRows(entries, p.fullPrice);
}

function scenario3(p, priceAfterDisc) {
    var downPayment = 250000;
    var installmentCount = p.totalDurationMonths || 70;
    var monthly = (priceAfterDisc - downPayment) / installmentCount;
    var lastAdj = (priceAfterDisc - downPayment) - monthly * (installmentCount - 1);

    var entries = [];
    entries.push({
        label: "Down Payment",
        month: formatMonth(p.startDate),
        payment: downPayment,
        isHighlight: true
    });

    for (var i = 1; i <= installmentCount; i++) {
        entries.push({
            label: ordinal(i) + " Installment",
            month: formatMonth(addMonths(p.startDate, i)),
            payment: i === installmentCount ? lastAdj : monthly
        });
    }

    return buildRows(entries, p.fullPrice);
}

function scenario4(p, priceAfterDisc) {
    var downPayment = priceAfterDisc * 0.05;
    var handoverPayment = priceAfterDisc * 0.05;
    var handoverIndex = 8;
    var totalSlots = p.totalDurationMonths || 70;
    var regularCount = totalSlots - 1;
    var remaining = priceAfterDisc - downPayment - handoverPayment;
    var monthly = remaining / regularCount;
    var lastAdj = remaining - monthly * (regularCount - 1);

    var entries = [];
    entries.push({
        label: "1st Installment",
        month: formatMonth(p.startDate),
        payment: downPayment,
        isHighlight: true
    });

    var installmentNum = 2;
    var regularIdx = 0;
    for (var i = 1; i <= totalSlots; i++) {
        var date = addMonths(p.startDate, i);
        if (i === handoverIndex) {
            entries.push({
                label: ordinal(installmentNum) + " Installment",
                month: formatMonth(date),
                payment: handoverPayment,
                isHighlight: true
            });
        } else {
            regularIdx++;
            var isLast = regularIdx === regularCount;
            entries.push({
                label: ordinal(installmentNum) + " Installment",
                month: formatMonth(date),
                payment: isLast ? lastAdj : monthly
            });
        }
        installmentNum++;
    }

    return buildRows(entries, p.fullPrice);
}

function scenarioBalloon(p, priceAfterDisc) {
    var cfg = p.balloonConfig;
    var totalMonths = p.totalDurationMonths || 60;

    var balloonMonths = [];
    if (cfg.timingMode === "manual" && cfg.manualMonths && cfg.manualMonths.length) {
        balloonMonths = cfg.manualMonths.slice(0, cfg.count);
    } else {
        var freq = cfg.frequencyMonths || 6;
        for (var b = 0; b < cfg.count; b++) {
            balloonMonths.push((b + 1) * freq);
        }
    }
    balloonMonths = balloonMonths.filter(function (m) { return m < totalMonths; });

    var balloonAmount = 0;
    if (cfg.amountMode === "total_percent") {
        var total = priceAfterDisc * ((cfg.totalBalloonPercent || 30) / 100);
        balloonAmount = total / (balloonMonths.length || 1);
    } else if (cfg.amountMode === "each_percent") {
        balloonAmount = priceAfterDisc * ((cfg.eachBalloonPercent || 7.5) / 100);
    } else {
        balloonAmount = cfg.eachBalloonFixed || 50000;
    }

    var totalBalloon = balloonAmount * balloonMonths.length;

    var balloonSet = new Set(balloonMonths);
    var regularMonths = [];
    for (var j = 0; j < totalMonths; j++) {
        if (!balloonSet.has(j)) {
            regularMonths.push(j);
        }
    }
    var remaining = priceAfterDisc - totalBalloon;
    var regularPayment = regularMonths.length > 0 ? remaining / regularMonths.length : 0;

    var allEntries = [];
    for (var m = 0; m < totalMonths; m++) {
        allEntries.push({
            month: m,
            label: balloonSet.has(m) ? "Balloon " + (balloonMonths.indexOf(m) + 1) : ordinal(m + 1) + " Installment",
            isBalloon: balloonSet.has(m)
        });
    }
    allEntries.sort(function (a, b) { return a.month - b.month; });

    var entries = [];
    var regularCount = 0;
    var totalSoFar = 0;

    for (var k = 0; k < allEntries.length; k++) {
        var entry = allEntries[k];
        var date = addMonths(p.startDate, entry.month);
        var payment = 0;

        if (entry.isBalloon) {
            payment = balloonAmount;
        } else {
            regularCount++;
            var isLastRegular = regularCount === regularMonths.length;
            if (isLastRegular) {
                payment = isLastRegular ? (remaining - regularPayment * (regularMonths.length - 1)) : regularPayment;
            } else {
                payment = regularPayment;
            }
        }

        totalSoFar += payment;
        entries.push({
            label: entry.label,
            month: formatMonth(date),
            payment: payment,
            isHighlight: entry.isBalloon
        });
    }

    var currentTotal = entries.reduce(function (s, e) { return s + e.payment; }, 0);
    var diff = priceAfterDisc - currentTotal;
    if (Math.abs(diff) > 0.001) {
        entries[entries.length - 1].payment += diff;
    }

    return buildRows(entries, p.fullPrice);
}

function computeSchedule(params) {
    var discountRate = params.discountRate || 0;
    var managementFeeRate = params.managementFeeRate || 0.025;
    var priceAfterDisc = params.fullPrice - params.fullPrice * discountRate;

    var rows = [];
    switch (String(params.scenarioId)) {
        case "1":
            rows = scenario1(params, priceAfterDisc);
            break;
        case "2":
            rows = scenario2(params, priceAfterDisc);
            break;
        case "3":
            rows = scenario3(params, priceAfterDisc);
            break;
        case "4":
            rows = scenario4(params, priceAfterDisc);
            break;
        case "balloon":
            rows = scenarioBalloon(params, priceAfterDisc);
            break;
        default:
            rows = [];
    }

    return prependMgmtFeeRow(rows, params.fullPrice, managementFeeRate, params.startDate);
}

function computeUserSchedule(params) {
    var fullPrice = params.fullPrice;
    var managementFees = params.managementFees;
    var advanceAmount = params.advanceAmount;
    var handoverPaymentAmount = params.handoverPaymentAmount;
    var totalDurationMonths = params.totalDurationMonths;
    var startDate = params.startDate;
    var handoverDate = params.handoverDate;

    var remaining = fullPrice - advanceAmount - handoverPaymentAmount;
    var monthlyCount = totalDurationMonths > 0 ? totalDurationMonths : 1;
    var monthlyPayment = remaining / monthlyCount;

    var handoverMonthOffset = Math.round(
        (handoverDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24 * 30.44)
    );

    var installmentEntries = [];

    if (advanceAmount > 0) {
        installmentEntries.push({
            label: "Down Payment", // Can map to blade tags
            month: formatMonth(startDate),
            payment: advanceAmount,
            isHighlight: true
        });
    }

    var handoverInserted = false;
    for (var i = 0; i < monthlyCount; i++) {
        var offset = advanceAmount > 0 ? i + 1 : i;
        var date = addMonths(startDate, offset);
        var monthOffset = offset;

        if (handoverPaymentAmount > 0 && !handoverInserted && monthOffset >= handoverMonthOffset) {
            installmentEntries.push({
                label: "Handover Payment",
                month: formatMonth(handoverDate),
                payment: handoverPaymentAmount,
                isHighlight: true,
                isHandover: true
            });
            handoverInserted = true;
        }

        installmentEntries.push({
            label: ordinal(i + 1) + " Installment",
            month: formatMonth(date),
            payment: monthlyPayment
        });
    }

    if (handoverPaymentAmount > 0 && !handoverInserted) {
        installmentEntries.push({
            label: "Handover Payment",
            month: formatMonth(handoverDate),
            payment: handoverPaymentAmount,
            isHighlight: true,
            isHandover: true
        });
    }

    var cumulative = 0;
    var scheduleRows = installmentEntries.map(function (e) {
        cumulative += e.payment;
        return {
            label: e.label,
            month: e.month,
            payment: e.payment,
            percentage: (e.payment / fullPrice) * 100,
            totalPayment: cumulative,
            totalPercentage: (cumulative / fullPrice) * 100,
            dueAmount: fullPrice - cumulative,
            isHighlight: e.isHighlight
        };
    });

    var mgmtRow = {
        label: managementFees > 0 ? "Management Fees (2.5%)" : "Management Fees (Waived)",
        month: formatMonth(startDate),
        payment: managementFees,
        percentage: (managementFees / fullPrice) * 100,
        totalPayment: 0,
        totalPercentage: 0,
        dueAmount: fullPrice,
        isHighlight: false,
        isMgmtFee: true
    };

    return [mgmtRow].concat(scheduleRows);
}
