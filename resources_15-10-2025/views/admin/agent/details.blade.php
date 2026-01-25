@extends('admin.template.layout')

@section('header')
<style>
    .agency-details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px 0;
        border-bottom: 1px solid #dee2e6;
    }
    
    .breadcrumb-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }
    
    .breadcrumb-title a {
        color: #007bff;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .breadcrumb-title a:hover {
        color: #0056b3;
        text-decoration: underline;
    }
    
    .header-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-action.btn-gray {
        background-color: #6c757d;
        color: white;
    }
    
    .btn-action.btn-gold {
        background-color: #ffd700;
        color: #333;
    }
    
    .btn-action:hover {
        opacity: 0.8;
    }
    
    .agency-summary {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .agency-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .agency-avatar {
        width: 60px;
        height: 60px;
        background: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .agency-avatar i {
        color: white;
        font-size: 24px;
    }
    
    .status-dot {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 12px;
        height: 12px;
        background: #dc3545;
        border-radius: 50%;
        border: 2px solid white;
    }
    
    .agency-name {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }
    
    .agency-date {
        font-size: 14px;
        color: #666;
    }
    
    .agency-status {
        font-size: 14px;
        color: #666;
    }
    
    .status-active {
        color: #28a745;
        font-weight: bold;
    }
    
    .tab-navigation {
        display: flex;
        gap: 5px;
        margin-bottom: 20px;
    }
    
    .tab-btn {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: uppercase;
    }
    
    .tab-btn.active {
        background-color: #28a745;
        color: white;
    }
    
    .tab-btn.inactive {
        background-color: #ffd700;
        color: #333;
    }
    
    .tab-content {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        min-height: 400px;
    }
    
    .tab-pane {
        display: none;
    }
    
    .tab-pane.active {
        display: block;
    }
    
    /* Agency Info Tab Styles */
    .agency-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .info-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .info-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        position: relative;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .info-icon i {
        color: #333;
        font-size: 18px;
    }
    
    .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .info-content label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        margin: 0;
    }
    
    .info-content span {
        font-size: 14px;
        color: #333;
        font-weight: 600;
    }
    
    .view-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        flex-shrink: 0;
    }
    
    .view-btn:hover {
        background-color: #5a6268;
    }
    
    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table {
        margin: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #333;
    }
    
    .badge {
        font-size: 11px;
        padding: 4px 8px;
    }
    
    /* Employees Tab Styles */
    .employees-header {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .search-section {
        margin-bottom: 15px;
    }
    
    .search-bar input {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .filters-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .date-filters {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .date-input {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .date-input label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
    }
    
    .date-input input {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 6px 10px;
        font-size: 12px;
    }
    
    .selection-info {
        font-size: 14px;
        color: #666;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .agent-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .agent-avatar {
        width: 30px;
        height: 30px;
        background: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .agent-avatar i {
        color: white;
        font-size: 14px;
    }
    
    .agent-avatar .status-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        background: #dc3545;
        border-radius: 50%;
        border: 1px solid white;
    }
    
    .agent-name {
        font-weight: 500;
        color: #333;
    }
    
    .status-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .status-text {
        font-weight: 500;
    }
    
    .text-success {
        color: #28a745 !important;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
    
    .agent-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .agent-info-header h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }
    
    .form-indicator .badge {
        font-size: 11px;
        padding: 4px 8px;
    }
    
    /* Agent Info Grid for Employees Tab */
    #employees .agent-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    #employees .info-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    #employees .info-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        position: relative;
    }
    
    #employees .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    #employees .info-icon i {
        color: #333;
        font-size: 18px;
    }
    
    #employees .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    #employees .info-content label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        margin: 0;
    }
    
    #employees .info-content span {
        font-size: 14px;
        color: #333;
        font-weight: 600;
    }
    
    #employees .view-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        flex-shrink: 0;
    }
    
    #employees .view-btn:hover {
        background-color: #5a6268;
    }
    
    /* Visit Schedule Tab Styles */
    .visit-schedule-header {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .client-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .client-avatar {
        width: 30px;
        height: 30px;
        background: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .client-avatar i {
        color: white;
        font-size: 14px;
    }
    
    .client-avatar .status-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        background: #dc3545;
        border-radius: 50%;
        border: 1px solid white;
    }
    
    .client-name {
        font-weight: 500;
        color: #333;
    }
    
    .visit-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .visit-date {
        font-weight: 500;
        color: #333;
    }
    
    .schedule-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .schedule-info-header h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }
    
    /* Schedule Info Grid for Visit Schedule Tab */
    #visit-schedule .schedule-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    #visit-schedule .info-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    #visit-schedule .info-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        position: relative;
    }
    
    #visit-schedule .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    #visit-schedule .info-icon i {
        color: #333;
        font-size: 18px;
    }
    
    #visit-schedule .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    #visit-schedule .info-content label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        margin: 0;
    }
    
    #visit-schedule .info-content span {
        font-size: 14px;
        color: #333;
        font-weight: 600;
    }
    
    #visit-schedule .view-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        flex-shrink: 0;
    }
    
    #visit-schedule .view-btn:hover {
        background-color: #5a6268;
    }
    
    /* Reservations Tab Styles */
    .reservations-header {
        margin-bottom: 30px;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    
    .reservations-header .filters-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .reservations-header .date-filters {
        display: flex;
        gap: 20px;
        align-items: end;
    }
    
    .reservations-header .date-input {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 150px;
    }
    
    .reservations-header .date-input label {
        font-size: 13px;
        color: #495057;
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .reservations-header .date-input input {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 10px 12px;
        font-size: 14px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .reservations-header .date-input input:focus {
        border-color: #007bff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .reservations-header .selection-info {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }
    
    .reservations-header .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .reservations-header .action-buttons .btn {
        padding: 8px 16px;
        font-size: 13px;
        border-radius: 6px;
        font-weight: 500;
    }
    
    .reservations-title-bar {
        background: #6c757d;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .select-all-toggle {
        color: #28a745;
        font-size: 20px;
        cursor: pointer;
    }
    
    .title-text {
        font-size: 18px;
        font-weight: bold;
        flex: 1;
        text-align: center;
    }
    
    .reservations-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 10px;
    }
    
    .reservation-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        position: relative;
        margin-bottom: 20px;
    }
    
    .card-checkbox {
        margin-top: 10px;
    }
    
    .card-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .property-image {
        width: 250px;
        height: 180px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .property-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        background: #e9ecef;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .no-image i {
        font-size: 24px;
        margin-bottom: 8px;
    }
    
    .reservation-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .property-title {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        line-height: 1.3;
        margin-bottom: 8px;
    }
    
    .unit-info {
        font-size: 16px;
        color: #666;
        margin-bottom: 12px;
        font-weight: 500;
    }
    
    .project-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 12px;
    }
    
    .download-link {
        margin: 12px 0;
    }
    
    .download-reservation-form {
        color: #dc3545;
        text-decoration: underline;
        font-size: 14px;
        font-weight: 500;
    }
    
    .download-reservation-form:hover {
        color: #c82333;
    }
    
    .details-row {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    
    .detail-field {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 180px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .commission-field {
        position: relative;
    }
    
    .field-label {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }
    
    .field-value {
        font-weight: 700;
        color: #333;
        font-size: 14px;
    }
    
    .commission-controls,
    .status-controls {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .commission-controls i,
    .status-controls i {
        font-size: 10px;
        color: #666;
        cursor: pointer;
    }
    
    .status-field {
        position: relative;
    }
    
    .status-badge {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: white;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-waitingapproval {
        background-color: #6c757d;
        color: white;
    }
    
    .status-reserved {
        background-color: #28a745;
        color: white;
    }
    
    .status-preparingdocument {
        background-color: #fd7e14;
        color: white;
    }
    
    .status-closeddeal {
        background-color: #dc3545;
        color: white;
    }
    
    .expand-button {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: #ffd700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .expand-button:hover {
        background: #ffed4e;
        transform: scale(1.1);
    }
    
    .expand-button i {
        color: #333;
        font-size: 16px;
    }
    
    .no-reservations {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 300px;
    }
    
    .no-reservations-content {
        text-align: center;
        color: #6c757d;
    }
    
    .no-reservations-content i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #dee2e6;
    }
    
    .no-reservations-content h4 {
        margin-bottom: 8px;
        color: #495057;
    }
    
    /* Commission Modal Styles */
    .commission-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }
    
    /* Status Modal Styles */
    .status-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }
    
    .status-modal-content {
        position: relative;
        background-color: white;
        margin: 15% auto;
        padding: 40px 30px 30px 30px;
        border-radius: 16px;
        width: 400px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        text-align: center;
    }
    
    .status-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 30px;
        height: 30px;
        background: #f8f9fa;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #666;
        transition: all 0.2s;
    }
    
    .status-modal-close:hover {
        background: #e9ecef;
        color: #333;
    }
    
    .status-modal-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .status-dropdown-container {
        margin-bottom: 25px;
        position: relative;
    }
    
    .status-dropdown {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        text-align: left;
        background: #f8f9fa;
        color: #333;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }
    
    .status-dropdown:focus {
        outline: none;
        border-color: #ffd700;
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
    }
    
    .status-dropdown-arrow {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        font-size: 14px;
        pointer-events: none;
    }
    
    .status-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid #e9ecef;
        border-top: none;
        border-radius: 0 0 12px 12px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1001;
        display: none;
    }
    
    .status-option {
        padding: 12px 20px;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
        transition: background-color 0.2s;
        font-weight: 500;
    }
    
    .status-option:hover {
        background-color: #f8f9fa;
    }
    
    .status-option:last-child {
        border-bottom: none;
    }
    
    .status-option.selected {
        background-color: #e3f2fd;
        color: #1976d2;
    }
    
    .status-done-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .status-done-btn:hover {
        background: linear-gradient(135deg, #ffed4e, #ffd700);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    }
    
    .status-done-btn:active {
        transform: translateY(0);
    }
    
    .commission-modal-content {
        position: relative;
        background-color: white;
        margin: 15% auto;
        padding: 40px 30px 30px 30px;
        border-radius: 16px;
        width: 350px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        text-align: center;
    }
    
    .commission-modal-icon {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border: 3px solid #ffd700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .commission-modal-icon i {
        font-size: 24px;
        color: #333;
        font-weight: bold;
    }
    
    .commission-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 30px;
        height: 30px;
        background: #f8f9fa;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #666;
        transition: all 0.2s;
    }
    
    .commission-modal-close:hover {
        background: #e9ecef;
        color: #333;
    }
    
    .commission-modal-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .commission-input-group {
        margin-bottom: 25px;
    }
    
    .commission-input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        background: #f8f9fa;
        color: #333;
        transition: all 0.2s;
    }
    
    .commission-input:focus {
        outline: none;
        border-color: #ffd700;
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
    }
    
    .commission-done-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .commission-done-btn:hover {
        background: linear-gradient(135deg, #ffed4e, #ffd700);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
    }
    
    .commission-done-btn:active {
        transform: translateY(0);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .agency-info-grid {
            grid-template-columns: 1fr;
        }
        
        #employees .agent-info-grid {
            grid-template-columns: 1fr;
        }
        
        #visit-schedule .schedule-info-grid {
            grid-template-columns: 1fr;
        }
        
        .reservation-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .property-image {
            width: 100%;
            max-width: 350px;
            height: 220px;
        }
        
        .details-row {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }
        
        .detail-field {
            min-width: auto;
            justify-content: center;
        }
        
        .agency-summary {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .tab-navigation {
            flex-wrap: wrap;
        }
        
        .tab-btn {
            flex: 1;
            min-width: 120px;
        }
        
        .filters-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .date-filters {
            justify-content: center;
        }
        
        .action-buttons {
            justify-content: center;
        }
        
        .reservations-header .filters-section {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }
        
        .reservations-header .date-filters {
            justify-content: center;
            gap: 15px;
        }
        
        .reservations-header .date-input {
            min-width: 120px;
        }
        
        .reservations-header .action-buttons {
            justify-content: center;
        }
    }
</style>
@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <!-- Header -->
            <div class="agency-details-header">
                <h1 class="breadcrumb-title">
                    AGENCIES / 
                    <a href="{{ url('admin/agency/details/' . $agent->agency_id) }}" style="color: #007bff; text-decoration: none;">{{ strtoupper($agent->agency->name ?? 'N/A') }}</a> / 
                    {{ strtoupper($agent->name) }} / 
                    <span id="currentTabTitle">AGENT INFO</span>
                </h1>
                <div class="header-actions">
                    <!-- <button class="btn-action btn-gray">Edit</button>
                    <button class="btn-action btn-gold">Approve</button> -->
                </div>
            </div>
            
            <!-- Agent Summary -->
            <div class="agency-summary">
                <div class="agency-info">
                    <div class="agency-avatar">
                        <i class="fas fa-user"></i>
                        <div class="status-dot"></div>
                    </div>
                    <div>
                        <h3 class="agency-name">{{ $agent->name }}</h3>
                    </div>
                </div>
                <div class="agency-date">{{ web_date_in_timezone($agent->created_at, 'd-M-Y') }}</div>
                <div class="agency-status">Status: <span class="status-active">{{ $agent->active ? 'Active' : 'Inactive' }}</span></div>
            </div>
            
            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="agent-info">AGENT INFO</button>
                <button class="tab-btn inactive" data-tab="reservations">RESERVATIONS</button>
                <button class="tab-btn inactive" data-tab="visit-schedule">VISIT SCHEDULE</button>
            </div>
            
            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Agent Info Tab -->
                <div id="agent-info" class="tab-pane active">
                    <div class="agency-info-grid">
                        <!-- Left Column -->
                        <div class="info-column">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="info-content">
                                    <label>Agency Name</label>
                                    <span>{{ $agent->agency->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <label>Agent Email Address</label>
                                    <span>{{ $agent->email ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="info-content">
                                    <label>ID Card</label>
                                    @if(!$agent->id_card)
                                        <span>N/A</span>
                                    @endif
                                </div>
                                @if($agent->id_card)
                                    <button class="view-btn" onclick="window.open('{{ aws_asset_path($agent->id_card) }}', '_blank')">View</button>
                                @endif
                            </div>
                            
                        </div>
                        
                        <!-- Right Column -->
                        <div class="info-column">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <label>Agent Phone Number</label>
                                    <span>{{ $agent->phone ?? 'N/A' }}</span>
                                </div>
                            </div>
                            
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="info-content">
                                    <label>Professional License</label>
                                    @if(!$agent->license)
                                        <span>N/A</span>
                                    @endif
                                </div>
                                @if($agent->license)
                                    <button class="view-btn" onclick="window.open('{{ aws_asset_path($agent->license) }}', '_blank')">View</button>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                
                
                <!-- Reservations Tab -->
                <div id="reservations" class="tab-pane">
                    <!-- Header with Filters -->
                    <div class="reservations-header">
                        <div class="filters-section">
                            <div class="date-filters">
                                <div class="date-input">
                                    <label>From</label>
                                    <input type="date" class="form-control" id="fromDateReservation">
                                </div>
                                <div class="date-input">
                                    <label>To</label>
                                    <input type="date" class="form-control" id="toDateReservation">
                                </div>
                            </div>
                            
                            <div class="selection-info">
                                <span id="selectedCountReservation">0 items selected</span>
                            </div>
                            
                            <div class="action-buttons">
                                <button class="btn btn-primary btn-sm">Export</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                        
                        <div class="reservations-title-bar">
                            <div class="select-all-toggle">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="title-text">RESERVATIONS</div>
                        </div>
                    </div>
                    
                    <!-- Reservation Cards -->
                    <div class="reservations-container">
                        @forelse($reservations ?? [] as $index => $reservation)
                        <div class="reservation-card">
                            <div class="card-checkbox">
                                <input type="checkbox" class="reservation-checkbox" value="{{ $reservation->id }}">
                            </div>
                            
                            <!-- Property Image -->
                            <div class="property-image">
                                @if($reservation->property && $reservation->property->images && $reservation->property->images->count() > 0)
                                    <img src="{{ aws_asset_path($reservation->property->images->first()->image) }}" alt="{{ $reservation->property->name }}" class="property-img">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-home"></i>
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Reservation Details -->
                            <div class="reservation-details">
                                <div class="property-title">
                                    {{ $reservation->property->name ?? 'N/A' }}
                                </div>
                                
                                <div class="unit-info">
                                    Unit 303
                                </div>
                                
                                <div class="project-info">
                                    Project: {{ $reservation->property->project->name ?? 'N/A' }}
                                </div>
                                
                                <div class="download-link">
                                    <a href="#" class="download-reservation-form">Download Reservation Form</a>
                                </div>
                                
                                <div class="details-row">
                                    <div class="detail-field">
                                        <span class="field-label">Price:</span>
                                        <span class="field-value">{{ number_format($reservation->property->price ?? 0) }} QAR</span>
                                    </div>
                                    <div class="detail-field commission-field" onclick="openCommissionModal({{ $reservation->id }}, {{ $reservation->commission ?? 0 }})" style="cursor: pointer;">
                                        <span class="field-label">Commission:</span>
                                        <span class="field-value commission-value">{{ $reservation->commission ?? 0 }}%</span>
                                        <div class="commission-controls">
                                            <i class="fas fa-chevron-up"></i>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="details-row">
                                    <div class="detail-field">
                                        <span class="field-label">Agent Name:</span>
                                        <span class="field-value">{{ $reservation->agent->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="status-field" onclick="openStatusModal({{ $reservation->id }}, '{{ $reservation->status }}', '{{ $reservation->status_label }}')" style="cursor: pointer;">
                                        <span class="status-badge status-{{ strtolower($reservation->status) }}">
                                            {{ $reservation->status_label }}
                                        </span>
                                        <div class="status-controls">
                                            <i class="fas fa-chevron-up"></i>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Expand Button -->
                            <div class="expand-button">
                                <i class="fas fa-arrow-up-right"></i>
                            </div>
                        </div>
                        @empty
                        <div class="no-reservations">
                            <div class="no-reservations-content">
                                <i class="fas fa-calendar-times"></i>
                                <h4>No Reservations Found</h4>
                                <p>No reservations found for this agency.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    
                    <!-- Commission Modal -->
                    <div id="commissionModal" class="commission-modal">
                        <div class="commission-modal-content">
                            <div class="commission-modal-icon">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <button class="commission-modal-close" onclick="closeCommissionModal()">
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <h3 class="commission-modal-title">Change Commission</h3>
                            
                            <div class="commission-input-group">
                                <input type="number" id="commissionInput" class="commission-input" placeholder="1.5%" step="0.1" min="0" max="100">
                            </div>
                            
                            <button class="commission-done-btn" onclick="updateCommission()">Done</button>
                        </div>
                    </div>
                    
                    <!-- Status Modal -->
                    <div id="statusModal" class="status-modal">
                        <div class="status-modal-content">
                            <button class="status-modal-close" onclick="closeStatusModal()">
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <h3 class="status-modal-title">Change Status</h3>
                            
                            <div class="status-dropdown-container">
                                <div class="status-dropdown" id="statusDropdown" onclick="toggleStatusOptions()">
                                    <span id="selectedStatusText">Waiting Approval</span>
                                    <i class="fas fa-chevron-down status-dropdown-arrow"></i>
                                </div>
                                <div class="status-options" id="statusOptions">
                                    <div class="status-option" data-value="waitingApproval" onclick="selectStatus('waitingApproval', 'Waiting Approval')">Waiting Approval</div>
                                    <div class="status-option" data-value="Reserved" onclick="selectStatus('Reserved', 'Reserved')">Reserved</div>
                                    <div class="status-option" data-value="PreparingDocument" onclick="selectStatus('PreparingDocument', 'Preparing Document')">Preparing Document</div>
                                    <div class="status-option" data-value="ClosedDeal" onclick="selectStatus('ClosedDeal', 'Closed Deal')">Closed Deal</div>
                                </div>
                            </div>
                            
                            <button class="status-done-btn" onclick="updateStatus()">Done</button>
                        </div>
                    </div>
                </div>
                
                <!-- Visit Schedule Tab -->
                <div id="visit-schedule" class="tab-pane">
                    <!-- Search and Filters -->
                    <div class="visit-schedule-header">
                        <div class="search-section">
                            <div class="search-bar">
                                <input type="text" class="form-control" placeholder="Search By Name | Email | Phone Number" id="visitScheduleSearch">
                            </div>
                        </div>
                        
                        <div class="filters-section">
                            <div class="date-filters">
                                <div class="date-input">
                                    <label>From</label>
                                    <input type="date" class="form-control" id="fromDateVisit">
                                </div>
                                <div class="date-input">
                                    <label>To</label>
                                    <input type="date" class="form-control" id="toDateVisit">
                                </div>
                            </div>
                            
                            <div class="selection-info">
                                <span id="selectedCountVisit">0 items selected</span>
                            </div>
                            
                            <div class="action-buttons">
                                <button class="btn btn-primary btn-sm">Export</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Master-Details Table -->
                    <div class="table-container">
                        <table class="table table-hover" id="visitScheduleTable">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAllVisitSchedules" onclick="toggleAllVisitSchedules(this)">
                                    </th>
                                    <th>Agent Name</th>
                                    <th>Unit Type</th>
                                    <th>Phone Number</th>
                                    <th>Date Of Visit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($visitSchedules ?? [] as $index => $schedule)
                                <!-- Main Row -->
                                <tr class="main-row" data-id="{{ $schedule->id }}">
                                    <td>
                                        <input type="checkbox" class="visit-schedule-checkbox" value="{{ $schedule->id }}">
                                    </td>
                                    <td>
                                        <div class="client-info">
                                            <div class="client-avatar">
                                                <i class="fas fa-user"></i>
                                                <div class="status-dot"></div>
                                            </div>
                                            <span class="client-name">{{ $schedule->agent->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $schedule->unit_type ?? 'N/A' }}</td>
                                    <td>{{ $schedule->client_phone_number }}</td>
                                    <td>
                                        <div class="visit-section">
                                            <span class="visit-date" data-date="{{ $schedule->visit_time }}">{{ web_date_in_timezone($schedule->visit_time, 'd-M-Y') }}</span>
                                            <!-- <button class="btn btn-sm btn-info">View</button> -->
                                            <i class="fas fa-chevron-down expand-icon" style="margin-left: 10px; cursor: pointer;"></i>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Detail Row -->
                                <tr class="detail-row" data-parent="{{ $schedule->id }}" style="display: none;">
                                    <td colspan="5">
                                        <div class="detail-content">
                                            <div class="schedule-info-header">
                                                <h6>SCHEDULE INFO</h6>
                                                <div class="header-actions">
                                                    <div class="form-indicator">
                                                        <span class="badge badge-info">1 Active Form Submitted</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="schedule-info-grid">
                                                <!-- Left Column -->
                                                <div class="info-column">
                                                    <div class="info-card">
                                                        <div class="info-icon">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <div class="info-content">
                                                            <label>Client Name</label>
                                                            <span>{{ $schedule->client_name ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="info-card">
                                                        <div class="info-icon">
                                                            <i class="fas fa-envelope"></i>
                                                        </div>
                                                        <div class="info-content">
                                                            <label>Client Email Address</label>
                                                            <span>{{ $schedule->client_email_address ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="info-card">
                                                        <div class="info-icon">
                                                            <i class="fas fa-building"></i>
                                                        </div>
                                                        <div class="info-content">
                                                            <label>Project</label>
                                                            <span>{{ $schedule->project->name ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="info-card">
                                                        <div class="info-icon">
                                                            <i class="fas fa-id-card"></i>
                                                        </div>
                                                        <div class="info-content">
                                                            <label>Client ID</label>
                                                            @if(!$schedule->client_id)
                                                                <span>N/A</span>
                                                            @endif
                                                        </div>
                                                        @if($schedule->client_id)
                                                            <button class="view-btn" onclick="window.open('{{ aws_asset_path($schedule->client_id) }}', '_blank')">View</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Right Column -->
                                                <div class="info-column">
                                                    <div class="info-card">
                                                        <div class="info-icon">
                                                            <i class="fas fa-phone"></i>
                                                        </div>
                                                        <div class="info-content">
                                                            <label>Client Phone Number</label>
                                                            <span>{{ $schedule->client_phone_number ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="info-card">
                                                        <div class="info-icon">
                                                            <i class="fas fa-clock"></i>
                                                        </div>
                                                        <div class="info-content">
                                                            <label>Visit Time</label>
                                                            <span>{{ web_date_in_timezone($schedule->visit_time, 'd-M-Y h:i A') ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="info-card">
                                                        <div class="info-icon">
                                                            <i class="fas fa-home"></i>
                                                        </div>
                                                        <div class="info-content">
                                                            <label>Unit Type</label>
                                                            <span>{{ $schedule->unit_type ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No visit schedules found for this agency.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all buttons and panes
                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.add('inactive');
                });
                
                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                });
                
                // Add active class to clicked button and corresponding pane
                this.classList.remove('inactive');
                this.classList.add('active');
                
                const targetPane = document.getElementById(targetTab);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
                
                // Update breadcrumb title based on selected tab
                updateBreadcrumbTitle(targetTab);
            });
        });
        
        // Function to update breadcrumb title based on selected tab
        function updateBreadcrumbTitle(tabId) {
            const tabTitles = {
                'agent-info': 'AGENT INFO',
                'reservations': 'RESERVATIONS',
                'visit-schedule': 'VISIT SCHEDULE'
            };
            
            const currentTabTitle = document.getElementById('currentTabTitle');
            if (currentTabTitle && tabTitles[tabId]) {
                currentTabTitle.textContent = tabTitles[tabId];
            }
        }
        
        // View button functionality
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const card = this.closest('.info-card');
                const label = card.querySelector('label').textContent;
                const value = card.querySelector('span').textContent;
                
                if (value !== 'N/A') {
                    Swal.fire({
                        title: label,
                        text: value,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: label,
                        text: 'No information available',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
        
        // Header action buttons
        document.querySelectorAll('.btn-action').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isApprove = this.classList.contains('btn-gold');
                const action = isApprove ? 'approve' : 'edit';
                const icon = isApprove ? 'success' : 'info';
                const title = isApprove ? 'Approve Agency' : 'Edit Agency';
                const text = isApprove ? 'Are you sure you want to approve this agency?' : 'Do you want to edit this agency?';
                
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: isApprove ? '#28a745' : '#007bff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isApprove ? 'Yes, approve!' : 'Yes, edit!'
                }).then((result) => {
                    if (result.value) {
                        if (isApprove) {
                            // Here you can add the actual approval logic
                            Swal.fire({
                                title: 'Success!',
                                text: 'Agency has been approved successfully.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            // Here you can add the edit logic
                            Swal.fire({
                                title: 'Edit Mode',
                                text: 'Edit functionality will be implemented here.',
                                icon: 'info'
                            });
                        }
                    }
                });
            });
        });
        
        // Download Document Function
        function downloadDocument(filename) {
            if (filename && filename !== 'N/A') {
                window.open('{{ url("admin/customer/download-document") }}/' + filename, '_blank');
            } else {
                Swal.fire({
                    title: 'No Document',
                    text: 'No document available for download.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        }
        
        // Visit Schedule tab functionality
        function toggleAllVisitSchedules(source) {
            document.querySelectorAll('.visit-schedule-checkbox').forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateSelectedCountVisit();
        }
        
        function updateSelectedCountVisit() {
            const selected = document.querySelectorAll('.visit-schedule-checkbox:checked').length;
            document.getElementById('selectedCountVisit').textContent = `${selected} items selected`;
        }
        
        // Visit schedule checkbox change
        document.querySelectorAll('.visit-schedule-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCountVisit);
        });
        
        // Visit schedule export functionality
        document.querySelectorAll('#visit-schedule .btn-primary').forEach(button => {
            if (button.textContent.trim() === 'Export') {
                button.addEventListener('click', function() {
                    const selectedSchedules = document.querySelectorAll('.visit-schedule-checkbox:checked');
                    if (selectedSchedules.length === 0) {
                        Swal.fire({
                            title: 'No Selection',
                            text: 'Please select visit schedules to export',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    
                    const scheduleIds = Array.from(selectedSchedules).map(cb => cb.value);
                    
                    Swal.fire({
                        title: 'Export Visit Schedules',
                        text: `Export ${selectedSchedules.length} selected visit schedule(s)?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#007bff',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, export!'
                    }).then((result) => {
                        if (result.value) {
                            // Create export URL with selected IDs
                            const exportUrl = `/admin/agent/export-visit-schedules?ids=${scheduleIds.join(',')}`;
                            window.open(exportUrl, '_blank');
                            
                            Swal.fire({
                                title: 'Export Started',
                                text: 'Visit schedule data export has been initiated',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                });
            }
        });
        
        // Visit schedule delete functionality
        document.querySelectorAll('#visit-schedule .btn-danger').forEach(button => {
            if (button.textContent.trim() === 'Delete') {
                button.addEventListener('click', function() {
                    const selectedSchedules = document.querySelectorAll('.visit-schedule-checkbox:checked');
                    if (selectedSchedules.length === 0) {
                        Swal.fire({
                            title: 'No Selection',
                            text: 'Please select visit schedules to delete',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    
                    Swal.fire({
                        title: 'Delete Visit Schedules',
                        text: `Are you sure you want to delete ${selectedSchedules.length} selected visit schedule(s)? This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete!'
                    }).then((result) => {
                        if (result.value) {
                            const scheduleIds = Array.from(selectedSchedules).map(cb => cb.value);
                            
                            // Get CSRF token
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                            
                            // Make AJAX call to delete visit schedules
                            fetch('/admin/agent/delete-visit-schedules', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    schedule_ids: scheduleIds
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === '1') {
                                    // Remove deleted rows from the table
                                    selectedSchedules.forEach(checkbox => {
                                        const row = checkbox.closest('.main-row');
                                        const rowId = row.getAttribute('data-id');
                                        const detailRow = document.querySelector(`#visit-schedule .detail-row[data-parent="${rowId}"]`);
                                        
                                        row.remove();
                                        if (detailRow) {
                                            detailRow.remove();
                                        }
                                    });
                                    
                                    // Update selection count
                                    updateSelectedCountVisit();
                                    
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong while deleting visit schedules',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }
                    });
                });
            }
        });
        
        // Visit schedule expand/collapse functionality
        document.querySelectorAll('#visit-schedule .expand-icon').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                const row = this.closest('.main-row');
                const rowId = row.getAttribute('data-id');
                const detailRow = document.querySelector(`#visit-schedule .detail-row[data-parent="${rowId}"]`);
                
                if (detailRow.style.display === 'none' || detailRow.style.display === '') {
                    // Close all other detail rows in visit schedule tab
                    document.querySelectorAll('#visit-schedule .detail-row').forEach(detail => {
                        detail.style.display = 'none';
                    });
                    document.querySelectorAll('#visit-schedule .expand-icon').forEach(icon => {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    });
                    
                    // Open this detail row
                    detailRow.style.display = 'table-row';
                    this.classList.remove('fa-chevron-down');
                    this.classList.add('fa-chevron-up');
                } else {
                    // Close this detail row
                    detailRow.style.display = 'none';
                    this.classList.remove('fa-chevron-up');
                    this.classList.add('fa-chevron-down');
                }
            });
        });
        
        // Visit schedule view button functionality
        document.querySelectorAll('#visit-schedule .btn-info').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const row = this.closest('.main-row');
                const rowId = row.getAttribute('data-id');
                const detailRow = document.querySelector(`#visit-schedule .detail-row[data-parent="${rowId}"]`);
                const expandIcon = row.querySelector('.expand-icon');
                
                if (detailRow.style.display === 'none' || detailRow.style.display === '') {
                    // Close all other detail rows in visit schedule tab
                    document.querySelectorAll('#visit-schedule .detail-row').forEach(detail => {
                        detail.style.display = 'none';
                    });
                    document.querySelectorAll('#visit-schedule .expand-icon').forEach(icon => {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    });
                    
                    // Open this detail row
                    detailRow.style.display = 'table-row';
                    expandIcon.classList.remove('fa-chevron-down');
                    expandIcon.classList.add('fa-chevron-up');
                } else {
                    // Close this detail row
                    detailRow.style.display = 'none';
                    expandIcon.classList.remove('fa-chevron-up');
                    expandIcon.classList.add('fa-chevron-down');
                }
            });
        });
        
        // Visit schedule search functionality
        document.getElementById('visitScheduleSearch').addEventListener('input', function() {
            filterVisitSchedule();
        });
        
        // Visit schedule date filtering functionality
        document.getElementById('fromDateVisit').addEventListener('change', function() {
            filterVisitSchedule();
        });
        
        document.getElementById('toDateVisit').addEventListener('change', function() {
            filterVisitSchedule();
        });
        
        function filterVisitSchedule() {
            const searchTerm = document.getElementById('visitScheduleSearch').value.toLowerCase();
            const fromDate = document.getElementById('fromDateVisit').value;
            const toDate = document.getElementById('toDateVisit').value;
            const rows = document.querySelectorAll('#visitScheduleTable tbody tr.main-row');
            
            rows.forEach(row => {
                const agentName = row.querySelector('.client-name').textContent.toLowerCase();
                const unitType = row.cells[2].textContent.toLowerCase();
                const phoneNumber = row.cells[3].textContent.toLowerCase();
                const visitDateText = row.cells[4].textContent.toLowerCase();
                
                // Extract visit date from the visit date cell
                const visitDateSpan = row.querySelector('.visit-date');
                const visitDateValue = visitDateSpan ? visitDateSpan.getAttribute('data-date') : null;
                
                let showRow = true;
                
                // Apply search filter
                if (searchTerm && !agentName.includes(searchTerm) && !unitType.includes(searchTerm) && !phoneNumber.includes(searchTerm) && !visitDateText.includes(searchTerm)) {
                    showRow = false;
                }
                
                // Apply date filter
                if (showRow && (fromDate || toDate)) {
                    if (visitDateValue) {
                        const visitDate = new Date(visitDateValue);
                        const fromDateObj = fromDate ? new Date(fromDate) : null;
                        const toDateObj = toDate ? new Date(toDate) : null;
                        
                        // Set time to start of day for inclusive comparison
                        if (fromDateObj) {
                            fromDateObj.setHours(0, 0, 0, 0);
                        }
                        if (toDateObj) {
                            toDateObj.setHours(23, 59, 59, 999);
                        }
                        visitDate.setHours(0, 0, 0, 0);
                        
                        if (fromDateObj && visitDate < fromDateObj) {
                            showRow = false;
                        }
                        if (toDateObj && visitDate > toDateObj) {
                            showRow = false;
                        }
                    } else {
                        // If no data-date attribute, try to parse from the displayed text
                        // This is a fallback for cases where the data-date attribute might not be set
                        showRow = false;
                    }
                }
                
                if (showRow) {
                    row.style.display = '';
                    // Also show the corresponding detail row
                    const rowId = row.getAttribute('data-id');
                    const detailRow = document.querySelector(`#visit-schedule .detail-row[data-parent="${rowId}"]`);
                    if (detailRow) {
                        detailRow.style.display = '';
                    }
                } else {
                    row.style.display = 'none';
                    // Also hide the corresponding detail row
                    const rowId = row.getAttribute('data-id');
                    const detailRow = document.querySelector(`#visit-schedule .detail-row[data-parent="${rowId}"]`);
                    if (detailRow) {
                        detailRow.style.display = 'none';
                    }
                }
            });
        }
        
        // Reservations tab functionality
        function toggleAllReservations(source) {
            document.querySelectorAll('.reservation-checkbox').forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateSelectedCountReservation();
        }
        
        function updateSelectedCountReservation() {
            const selected = document.querySelectorAll('.reservation-checkbox:checked').length;
            document.getElementById('selectedCountReservation').textContent = `${selected} items selected`;
        }
        
        // Reservation checkbox change
        document.querySelectorAll('.reservation-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCountReservation);
        });
        
        // Reservation export functionality
        document.querySelectorAll('#reservations .btn-primary').forEach(button => {
            if (button.textContent.trim() === 'Export') {
                button.addEventListener('click', function() {
                    const selectedReservations = document.querySelectorAll('.reservation-checkbox:checked');
                    if (selectedReservations.length === 0) {
                        Swal.fire({
                            title: 'No Selection',
                            text: 'Please select reservations to export',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    
                    const reservationIds = Array.from(selectedReservations).map(cb => cb.value);
                    
                    Swal.fire({
                        title: 'Export Reservations',
                        text: `Export ${selectedReservations.length} selected reservation(s)?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#007bff',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, export!'
                    }).then((result) => {
                        if (result.value) {
                            // Create export URL with selected IDs
                            const exportUrl = `/admin/agent/export-reservations?ids=${reservationIds.join(',')}`;
                            window.open(exportUrl, '_blank');
                            
                            Swal.fire({
                                title: 'Export Started',
                                text: 'Reservation data export has been initiated',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                });
            }
        });
        
        // Reservation delete functionality
        document.querySelectorAll('#reservations .btn-danger').forEach(button => {
            if (button.textContent.trim() === 'Delete') {
                button.addEventListener('click', function() {
                    const selectedReservations = document.querySelectorAll('.reservation-checkbox:checked');
                    if (selectedReservations.length === 0) {
                        Swal.fire({
                            title: 'No Selection',
                            text: 'Please select reservations to delete',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    
                    Swal.fire({
                        title: 'Delete Reservations',
                        text: `Are you sure you want to delete ${selectedReservations.length} selected reservation(s)? This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete!'
                    }).then((result) => {
                        if (result.value) {
                            const reservationIds = Array.from(selectedReservations).map(cb => cb.value);
                            
                            // Get CSRF token
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                            
                            // Make AJAX call to delete reservations
                            fetch('/admin/agent/delete-reservations', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    reservation_ids: reservationIds
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === '1') {
                                    // Remove deleted rows from the table
                                    selectedReservations.forEach(checkbox => {
                                        const card = checkbox.closest('.reservation-card');
                                        card.remove();
                                    });
                                    
                                    // Update selection count
                                    updateSelectedCountReservation();
                                    
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong while deleting reservations',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }
                    });
                });
            }
        });
        
        // Select all toggle
        document.querySelector('.select-all-toggle').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.reservation-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
            updateSelectedCountReservation();
        });
        
        // Expand button functionality
        document.querySelectorAll('.expand-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const card = this.closest('.reservation-card');
                const reservationId = card.querySelector('.reservation-checkbox').value;
                
                Swal.fire({
                    title: 'Reservation Details',
                    text: `Viewing details for reservation ID: ${reservationId}`,
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            });
        });
        
        // Download reservation form
        document.querySelectorAll('.download-reservation-form').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const card = this.closest('.reservation-card');
                const reservationId = card.querySelector('.reservation-checkbox').value;
                
                Swal.fire({
                    title: 'Download Reservation Form',
                    text: `Downloading form for reservation ID: ${reservationId}`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
    
    // Commission Modal Functions
    let currentReservationId = null;
    
    function openCommissionModal(reservationId, currentCommission) {
        currentReservationId = reservationId;
        document.getElementById('commissionInput').value = currentCommission;
        document.getElementById('commissionModal').style.display = 'block';
        
        // Focus on input after modal opens
        setTimeout(() => {
            document.getElementById('commissionInput').focus();
        }, 100);
    }
    
    function closeCommissionModal() {
        document.getElementById('commissionModal').style.display = 'none';
        currentReservationId = null;
    }
    
    function updateCommission() {
        const newCommission = document.getElementById('commissionInput').value;
        
        if (newCommission === '' || newCommission < 0 || newCommission > 100) {
            Swal.fire({
                title: 'Invalid Commission',
                text: 'Please enter a valid commission percentage (0-100)',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        // Make AJAX call to update the database
        fetch('/admin/agent/update-reservation-commission', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                reservation_id: currentReservationId,
                commission: newCommission
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === '1') {
                // Update the commission value in the UI
                const commissionField = document.querySelector(`[onclick*="${currentReservationId}"] .commission-value`);
                if (commissionField) {
                    commissionField.textContent = newCommission + '%';
                }
                
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Close modal
                closeCommissionModal();
            } else {
                // Handle error
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong while updating commission',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('commissionModal');
        if (event.target === modal) {
            closeCommissionModal();
        }
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeCommissionModal();
        }
    });
    
    // Handle Enter key in commission input
    document.getElementById('commissionInput').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            updateCommission();
        }
    });
    
    // Status Modal Functions
    let currentStatusReservationId = null;
    let currentSelectedStatus = null;
    
    function openStatusModal(reservationId, currentStatus, currentStatusLabel) {
        currentStatusReservationId = reservationId;
        currentSelectedStatus = currentStatus;
        
        // Set the current status as selected
        document.getElementById('selectedStatusText').textContent = currentStatusLabel;
        
        // Update the selected option in dropdown
        document.querySelectorAll('.status-option').forEach(option => {
            option.classList.remove('selected');
            if (option.getAttribute('data-value') === currentStatus) {
                option.classList.add('selected');
            }
        });
        
        // Show modal
        document.getElementById('statusModal').style.display = 'block';
    }
    
    function closeStatusModal() {
        document.getElementById('statusModal').style.display = 'none';
        document.getElementById('statusOptions').style.display = 'none';
        currentStatusReservationId = null;
        currentSelectedStatus = null;
    }
    
    function toggleStatusOptions() {
        const options = document.getElementById('statusOptions');
        const arrow = document.querySelector('.status-dropdown-arrow');
        
        if (options.style.display === 'none' || options.style.display === '') {
            options.style.display = 'block';
            arrow.classList.remove('fa-chevron-down');
            arrow.classList.add('fa-chevron-up');
        } else {
            options.style.display = 'none';
            arrow.classList.remove('fa-chevron-up');
            arrow.classList.add('fa-chevron-down');
        }
    }
    
    function selectStatus(statusValue, statusLabel) {
        currentSelectedStatus = statusValue;
        document.getElementById('selectedStatusText').textContent = statusLabel;
        
        // Update selected option
        document.querySelectorAll('.status-option').forEach(option => {
            option.classList.remove('selected');
            if (option.getAttribute('data-value') === statusValue) {
                option.classList.add('selected');
            }
        });
        
        // Close dropdown
        document.getElementById('statusOptions').style.display = 'none';
        document.querySelector('.status-dropdown-arrow').classList.remove('fa-chevron-up');
        document.querySelector('.status-dropdown-arrow').classList.add('fa-chevron-down');
    }
    
    function updateStatus() {
        if (!currentSelectedStatus || !currentStatusReservationId) {
            Swal.fire({
                title: 'Error!',
                text: 'Please select a status',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        // Make AJAX call to update the database
        fetch('/admin/agent/update-reservation-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                reservation_id: currentStatusReservationId,
                status: currentSelectedStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === '1') {
                // Update the status badge in the UI
                const statusField = document.querySelector(`[onclick*="${currentStatusReservationId}"] .status-badge`);
                if (statusField) {
                    // Update the status text
                    statusField.textContent = data.status_label;
                    
                    // Update the status class
                    statusField.className = `status-badge status-${currentSelectedStatus.toLowerCase()}`;
                }
                
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Close modal
                closeStatusModal();
            } else {
                // Handle error
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong while updating status',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // Close status modal when clicking outside
    window.addEventListener('click', function(event) {
        const statusModal = document.getElementById('statusModal');
        const statusDropdown = document.getElementById('statusDropdown');
        const statusOptions = document.getElementById('statusOptions');
        
        if (event.target === statusModal) {
            closeStatusModal();
        }
        
        // Close dropdown when clicking outside
        if (!statusDropdown.contains(event.target) && !statusOptions.contains(event.target)) {
            statusOptions.style.display = 'none';
            document.querySelector('.status-dropdown-arrow').classList.remove('fa-chevron-up');
            document.querySelector('.status-dropdown-arrow').classList.add('fa-chevron-down');
        }
    });
    
    // Close status modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeStatusModal();
        }
    });
</script>
@stop
