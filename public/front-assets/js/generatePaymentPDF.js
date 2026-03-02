// Brand colors — Light luxury palette
var NAVY = [26, 35, 54];
var CHARCOAL = [45, 45, 60];
var GOLD = [181, 148, 82];
var GOLD_DARK = [150, 118, 55];
var IVORY = [253, 250, 244];
var WHITE = [255, 255, 255];
var LIGHT_GRAY = [245, 244, 240];
var AMBER_BG = [255, 248, 225];
var AMBER_TEXT = [160, 110, 20];
var ROSE_BG = [255, 244, 244];
var ROSE_TEXT = [160, 40, 40];
var GOLD_BG = [250, 242, 220];
var GOLD_TEXT = [130, 95, 25];

var PAGE_W = 210;
var PAGE_H = 297;
var MARGIN_TOP = 14;
var MARGIN_SIDE = 14;
var FOOTER_HEIGHT = 26;
var CONTENT_BOTTOM = PAGE_H - FOOTER_HEIGHT;

function addTowerBackground(doc, bgImg, opacity) {
    if (!bgImg) return;
    try {
        doc.saveGraphicsState();
        doc.setGState(new doc.GState({ opacity: opacity }));
        doc.addImage(bgImg, "JPEG", 0, 0, PAGE_W, PAGE_H);
        doc.restoreGraphicsState();
    } catch (e) { }
}

function addIvoryOverlay(doc, opacity) {
    doc.saveGraphicsState();
    doc.setGState(new doc.GState({ opacity: opacity }));
    doc.setFillColor.apply(doc, IVORY);
    doc.rect(0, 0, PAGE_W, PAGE_H, "F");
    doc.restoreGraphicsState();
}

function drawPageBackground(doc, bgImg, ivoryOpacity) {
    addTowerBackground(doc, bgImg, 1.0);
    addIvoryOverlay(doc, ivoryOpacity);
}

function addHeader(doc, logoImgElem) {
    if (logoImgElem) {
        try {
            doc.addImage(logoImgElem, "PNG", 14, 5, 74, 28);
        } catch (e) { drawFallbackHeader(doc); }
    } else {
        drawFallbackHeader(doc);
    }

    doc.setDrawColor.apply(doc, GOLD);
    doc.setLineWidth(0.7);
    doc.line(14, 37, PAGE_W - 14, 37);
}

function drawFallbackHeader(doc) {
    doc.setFontSize(12);
    doc.setFont("helvetica", "bold");
    doc.setTextColor.apply(doc, NAVY);
    doc.text("BIN AL SHEIKH", 14, 18);
    doc.setFontSize(7);
    doc.setFont("helvetica", "normal");
    doc.text("REAL ESTATE BROKERAGE", 14, 23);
}

function addFooter(doc) {
    var footerY = PAGE_H - 18;

    doc.setDrawColor.apply(doc, GOLD);
    doc.setLineWidth(0.5);
    doc.line(14, footerY - 3, PAGE_W - 14, footerY - 3);

    doc.setFillColor.apply(doc, IVORY);
    doc.rect(0, footerY - 2, PAGE_W, 22, "F");

    doc.setTextColor.apply(doc, NAVY);
    doc.setFontSize(7.5);
    doc.setFont("helvetica", "bold");
    doc.text("www.bsbqa.com", 14, footerY + 5);
    doc.text("License No: 182", PAGE_W / 2, footerY + 3, { align: "center" });
    doc.text("CR: 155731", PAGE_W / 2, footerY + 8, { align: "center" });
    doc.text("+974 4001 1911", PAGE_W - 14, footerY + 3, { align: "right" });
    doc.text("+974 3066 6004", PAGE_W - 14, footerY + 8, { align: "right" });
}

function drawTitleBox(doc, startY) {
    var BOX_H = 20;
    var BOX_W = 116;
    var BOX_X = PAGE_W / 2 - BOX_W / 2;

    doc.setFillColor.apply(doc, IVORY);
    doc.roundedRect(BOX_X, startY, BOX_W, BOX_H, 2, 2, "F");

    doc.setDrawColor.apply(doc, GOLD);
    doc.setLineWidth(1.0);
    doc.roundedRect(BOX_X, startY, BOX_W, BOX_H, 2, 2, "S");

    doc.setLineWidth(0.3);
    doc.roundedRect(BOX_X + 2.5, startY + 2.5, BOX_W - 5, BOX_H - 5, 1.5, 1.5, "S");

    doc.setFillColor.apply(doc, GOLD);
    doc.circle(BOX_X + 3, startY + 3, 0.7, "F");
    doc.circle(BOX_X + BOX_W - 3, startY + 3, 0.7, "F");

    doc.setFontSize(15);
    doc.setFont("helvetica", "bold");
    doc.setTextColor.apply(doc, NAVY);
    doc.text("Custom Payment Plan", PAGE_W / 2, startY + BOX_H / 2 + 2.5, { align: "center" });

    return startY + BOX_H;
}

// Ensure the function is accessible globally
window.generatePDFFromData = function (property, schedule, logoUrl, bgUrl) {
    if (!window.jspdf || !window.jspdf.jsPDF) {
        alert("PDF generator engine is loading. Please try again in a moment.");
        return;
    }

    // Pre-load images before building PDF
    var pLogo = new Promise(function (res) {
        var img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function () { res(img); };
        img.onerror = function () { res(null); };
        img.src = logoUrl;
    });

    var pBg = new Promise(function (res) {
        var img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function () { res(img); };
        img.onerror = function () { res(null); };
        img.src = bgUrl;
    });

    Promise.all([pLogo, pBg]).then(function (imgs) {
        var logoImgElem = imgs[0];
        var bgImgElem = imgs[1];
        buildAndSaveJsPdf(property, schedule, logoImgElem, bgImgElem);
    });
};

function buildAndSaveJsPdf(property, schedule, logoImgElem, bgImgElem) {
    var doc = new window.jspdf.jsPDF({ unit: "mm", format: "a4" });

    drawPageBackground(doc, bgImgElem, 0.78);
    addHeader(doc, logoImgElem);

    var curY = 40;
    curY = drawTitleBox(doc, curY);
    curY += 2;

    doc.setFontSize(7.5);
    doc.setFont("helvetica", "italic");
    doc.setTextColor.apply(doc, ROSE_TEXT);
    var noteText =
        "Note: This plan is just a preview and is not considered an official final plan. " +
        "The official final plan is generated with the contract.";
    doc.text(noteText, PAGE_W / 2, curY + 4, { align: "center", maxWidth: 170 });
    curY += 10;

    doc.setFontSize(11);
    doc.setFont("helvetica", "bold");
    doc.setTextColor.apply(doc, GOLD_DARK);
    doc.text("Property Details", MARGIN_SIDE, curY + 4);

    doc.setDrawColor.apply(doc, GOLD);
    doc.setLineWidth(0.4);
    doc.line(MARGIN_SIDE, curY + 6, PAGE_W - MARGIN_SIDE, curY + 6);
    curY += 10;

    doc.autoTable({
        startY: curY,
        head: [["Project", "Unit Number", "Floor Number"]],
        body: [[
            property.project || "—",
            property.unitNumber,
            property.floorNumber || "—",
        ]],
        headStyles: { fillColor: GOLD, textColor: WHITE, fontStyle: "bold", fontSize: 9 },
        bodyStyles: { fontSize: 9, textColor: CHARCOAL, fillColor: WHITE },
        alternateRowStyles: { fillColor: LIGHT_GRAY },
        margin: { top: 45, left: MARGIN_SIDE, right: MARGIN_SIDE, bottom: FOOTER_HEIGHT },
        theme: "grid",
        styles: { cellPadding: 4, lineColor: [220, 215, 200], lineWidth: 0.3 },
    });
    curY = doc.lastAutoTable.finalY + 5;

    doc.autoTable({
        startY: curY,
        head: [["Gross Area", "Size Net", "Balcony Size", "Handover", "Installment"]],
        body: [[
            property.grossArea,
            property.sizeNet || "—",
            property.balconySize || "—",
            property.handoverAmount ? window.formatCurrency(property.handoverAmount) : "—",
            property.installmentCount ? property.installmentCount.toString() : "—",
        ]],
        headStyles: { fillColor: GOLD, textColor: WHITE, fontStyle: "bold", fontSize: 9 },
        bodyStyles: { fontSize: 9, textColor: CHARCOAL, fillColor: WHITE },
        alternateRowStyles: { fillColor: LIGHT_GRAY },
        margin: { top: 45, left: MARGIN_SIDE, right: MARGIN_SIDE, bottom: FOOTER_HEIGHT },
        theme: "grid",
        styles: { cellPadding: 4, lineColor: [220, 215, 200], lineWidth: 0.3 },
    });
    curY = doc.lastAutoTable.finalY + 5;

    doc.autoTable({
        startY: curY,
        head: [["Full Price", "Management Fees", "Total", "Date"]],
        body: [[
            window.formatCurrency(property.fullPrice),
            window.formatCurrency(property.managementFees),
            window.formatCurrency(property.total),
            property.date || new Date().toLocaleDateString("en-GB", {
                day: "2-digit", month: "short", year: "numeric",
            })
        ]],
        headStyles: { fillColor: NAVY, textColor: WHITE, fontStyle: "bold", fontSize: 9 },
        bodyStyles: { fontSize: 9, textColor: CHARCOAL, fillColor: WHITE },
        alternateRowStyles: { fillColor: LIGHT_GRAY },
        margin: { top: 45, left: MARGIN_SIDE, right: MARGIN_SIDE, bottom: FOOTER_HEIGHT },
        theme: "grid",
        styles: { cellPadding: 4, lineColor: [220, 215, 200], lineWidth: 0.3 },
    });
    curY = doc.lastAutoTable.finalY + 8;

    var SCHEDULE_HEADING_H = 12;
    var MIN_ROWS_HEIGHT = 30;
    var scheduleNeeds = SCHEDULE_HEADING_H + MIN_ROWS_HEIGHT;
    var remainingOnPage1 = CONTENT_BOTTOM - curY;
    var scheduleStartsOnPage1 = remainingOnPage1 >= scheduleNeeds;

    var scheduleStartY;

    if (scheduleStartsOnPage1) {
        doc.setFontSize(13);
        doc.setFont("helvetica", "bold");
        doc.setTextColor.apply(doc, GOLD_DARK);
        doc.text("Payment Schedule", MARGIN_SIDE, curY);
        doc.setDrawColor.apply(doc, GOLD);
        doc.setLineWidth(0.5);
        doc.line(MARGIN_SIDE, curY + 2.5, PAGE_W - MARGIN_SIDE, curY + 2.5);
        scheduleStartY = curY + 6;
    } else {
        addFooter(doc);
        doc.addPage();
        drawPageBackground(doc, bgImgElem, 0.88);
        addHeader(doc, logoImgElem);

        var headY = 47;
        doc.setFontSize(13);
        doc.setFont("helvetica", "bold");
        doc.setTextColor.apply(doc, GOLD_DARK);
        doc.text("Payment Schedule", MARGIN_SIDE, headY);
        doc.setDrawColor.apply(doc, GOLD);
        doc.setLineWidth(0.5);
        doc.line(MARGIN_SIDE, headY + 2.5, PAGE_W - MARGIN_SIDE, headY + 2.5);
        scheduleStartY = headY + 6;
    }

    var tableBody = schedule.map(function (row) {
        return [
            row.isMgmtFee || row.isHighlight ? row.label : row.month,
            window.formatPercent(row.percentage),
            window.formatCurrency(row.payment),
            row.isMgmtFee ? "—" : window.formatCurrency(row.totalPayment),
            row.isMgmtFee ? "—" : window.formatCurrency(row.dueAmount),
            row.isMgmtFee ? "—" : window.formatPercent(row.totalPercentage),
        ];
    });

    var pagesBeforeSchedule = doc.getNumberOfPages();

    doc.autoTable({
        startY: scheduleStartY,
        head: [["Timeline", "Monthly %", "Payment", "Total Accumulated", "Due Amount", "Total %"]],
        body: tableBody,
        headStyles: { fillColor: GOLD, textColor: WHITE, fontStyle: "bold", fontSize: 8.5 },
        bodyStyles: { fontSize: 8, textColor: CHARCOAL, fillColor: WHITE },
        alternateRowStyles: { fillColor: LIGHT_GRAY },
        margin: { top: 45, left: MARGIN_SIDE, right: MARGIN_SIDE, bottom: FOOTER_HEIGHT },
        theme: "grid",
        styles: { cellPadding: 3.5, lineColor: [220, 215, 200], lineWidth: 0.3 },
        didParseCell: function (data) {
            if (data.section === "body") {
                var row = schedule[data.row.index];
                if (row && row.isMgmtFee) {
                    data.cell.styles.fontStyle = "bold";
                    data.cell.styles.textColor = AMBER_TEXT;
                    data.cell.styles.fillColor = AMBER_BG;
                } else if (row && row.isHighlight) {
                    var label = (row.label || "").toLowerCase();
                    if (label.indexOf("handover") !== -1) {
                        data.cell.styles.fontStyle = "bold";
                        data.cell.styles.textColor = ROSE_TEXT;
                        data.cell.styles.fillColor = ROSE_BG;
                    } else {
                        data.cell.styles.fontStyle = "bold";
                        data.cell.styles.textColor = GOLD_TEXT;
                        data.cell.styles.fillColor = GOLD_BG;
                    }
                }
            }
        },
        didDrawPage: function (data) {
            addFooter(doc);
        },
        willDrawPage: function (data) {
            var currentPage = doc.getCurrentPageInfo().pageNumber;
            if (currentPage > pagesBeforeSchedule) {
                drawPageBackground(doc, bgImgElem, 0.88);
                addHeader(doc, logoImgElem);
            }
        },
    });

    addFooter(doc);
    doc.save("payment-plan-" + (property.unitNumber || "export") + ".pdf");
}
