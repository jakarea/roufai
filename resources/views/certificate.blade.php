<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Completion Certificate</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .certificate-container {
            width: 100%;
            max-width: 1000px;
            background: #ffffff;
            padding: 30px 45px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }

        /* Decorative border */
        .certificate-container::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            bottom: 12px;
            border: 3px solid #d4af37;
            pointer-events: none;
            border-radius: 5px;
        }

        /* Corner decorations */
        .corner-decoration {
            position: absolute;
            width: 70px;
            height: 70px;
            opacity: 0.1;
        }

        .corner-decoration.top-left {
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, #d4af37 0%, transparent 100%);
            border-radius: 0 0 100% 0;
        }

        .corner-decoration.top-right {
            top: 20px;
            right: 20px;
            background: linear-gradient(225deg, #d4af37 0%, transparent 100%);
            border-radius: 0 0 0 100%;
        }

        .corner-decoration.bottom-left {
            bottom: 20px;
            left: 20px;
            background: linear-gradient(45deg, #d4af37 0%, transparent 100%);
            border-radius: 0 100% 0 0;
        }

        .corner-decoration.bottom-right {
            bottom: 20px;
            right: 20px;
            background: linear-gradient(315deg, #d4af37 0%, transparent 100%);
            border-radius: 100% 0 0 0;
        }

        /* Header section */
        .certificate-header {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .certificate-badge {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .certificate-badge svg {
            width: 30px;
            height: 30px;
            fill: #ffffff;
        }

        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .certificate-subtitle {
            font-size: 14px;
            color: #718096;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Body section */
        .certificate-body {
            text-align: center;
            margin: 30px 0;
            position: relative;
            z-index: 1;
        }

        .certificate-text {
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            margin: 20px 0;
            padding: 12px 0;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            min-width: 300px;
        }

        .course-details {
            margin: 30px 0;
        }

        .detail-line {
            font-size: 14px;
            color: #4a5568;
            margin: 10px 0;
        }

        .course-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin: 8px 0;
            font-style: italic;
        }

        /* Footer section */
        .certificate-footer {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            position: relative;
            z-index: 1;
        }

        .signature-block {
            text-align: center;
            flex: 1;
            margin: 0 15px;
        }

        .signature-line {
            width: 180px;
            height: 50px;
            margin: 0 auto 10px;
            border-bottom: 2px solid #2d3748;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 5px;
        }

        .signature-name {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .signature-title {
            font-size: 12px;
            color: #718096;
            font-weight: 300;
        }

        .date-block {
            text-align: center;
            flex: 1;
            margin: 0 15px;
        }

        .date-label {
            font-size: 12px;
            color: #718096;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .date-value {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            padding: 8px 16px;
            border: 2px solid #d4af37;
            border-radius: 5px;
            display: inline-block;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 100px;
            color: rgba(102, 126, 234, 0.03);
            font-weight: 700;
            pointer-events: none;
            z-index: 0;
            font-family: 'Playfair Display', serif;
        }

        /* Print styles - Ensures certificate fits on one page */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .certificate-container {
                box-shadow: none;
                max-width: 100%;
                width: 297mm;
                /* A4 landscape width */
                padding: 30px 45px;
                page-break-inside: avoid;
                page-break-after: avoid;
                page-break-before: avoid;
                margin: 0;
                border-radius: 0;
                overflow: hidden;
            }

            .certificate-container::before {
                top: 12px;
                left: 12px;
                right: 12px;
                bottom: 12px;
            }

            .certificate-header {
                margin-bottom: 25px;
            }

            .certificate-badge {
                width: 60px;
                height: 60px;
                margin-bottom: 15px;
            }

            .certificate-badge svg {
                width: 30px;
                height: 30px;
            }

            .certificate-title {
                font-size: 36px;
                margin-bottom: 8px;
                letter-spacing: 1px;
            }

            .certificate-subtitle {
                font-size: 14px;
                letter-spacing: 2px;
            }

            .certificate-body {
                margin: 30px 0;
            }

            .certificate-text {
                font-size: 14px;
                margin-bottom: 20px;
                line-height: 1.6;
            }

            .recipient-name {
                font-size: 36px;
                margin: 20px 0;
                padding: 12px 0;
                min-width: 300px;
            }

            .course-details {
                margin: 30px 0;
            }

            .detail-line {
                font-size: 14px;
                margin: 10px 0;
            }

            .course-name {
                font-size: 20px;
                margin: 8px 0;
            }

            .certificate-footer {
                margin-top: 40px;
                padding-top: 30px;
            }

            .signature-block {
                margin: 0 15px;
            }

            .signature-line {
                width: 180px;
                height: 50px;
            }

            .signature-name {
                font-size: 16px;
            }

            .signature-title {
                font-size: 12px;
            }

            .date-block {
                margin: 0 15px;
            }

            .date-label {
                font-size: 12px;
                margin-bottom: 8px;
            }

            .date-value {
                font-size: 16px;
                padding: 8px 16px;
            }

            .watermark {
                font-size: 100px;
            }

            .corner-decoration {
                width: 70px;
                height: 70px;
            }

            .corner-decoration.top-left,
            .corner-decoration.top-right {
                top: 20px;
            }

            .corner-decoration.bottom-left,
            .corner-decoration.bottom-right {
                bottom: 20px;
            }

            .corner-decoration.top-left,
            .corner-decoration.bottom-left {
                left: 20px;
            }

            .corner-decoration.top-right,
            .corner-decoration.bottom-right {
                right: 20px;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .certificate-container {
                padding: 40px 30px;
            }

            .certificate-title {
                font-size: 36px;
            }

            .recipient-name {
                font-size: 36px;
                min-width: 300px;
            }

            .course-name {
                font-size: 22px;
            }

            .certificate-footer {
                flex-direction: column;
                gap: 30px;
            }

            .signature-block,
            .date-block {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <!-- Corner decorations -->
        <div class="corner-decoration top-left"></div>
        <div class="corner-decoration top-right"></div>
        <div class="corner-decoration bottom-left"></div>
        <div class="corner-decoration bottom-right"></div>

        <!-- Watermark -->
        <div class="watermark">CERTIFIED</div>

        <!-- Header -->
        <div class="certificate-header">
            <div class="certificate-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                </svg>
            </div>
            <h1 class="certificate-title">Certificate of Completion</h1>
            <p class="certificate-subtitle">This is to certify that</p>
        </div>

        <!-- Body -->
        <div class="certificate-body">
            <div class="recipient-name">{{ $student->name }}</div>

            <div class="course-details">
                <p class="detail-line">has successfully completed the online course</p>
                <div class="course-name">{{ $course->title }}</div>
                <p class="detail-line">with dedication and excellence</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="certificate-footer">
            <div class="signature-block">
                <div class="signature-line">
                    <!-- Signature image or text can go here -->
                </div>
                <div class="signature-name">{{ $course->instructor->name }}</div>
                <div class="signature-title">Course Instructor</div>
            </div>

            <div class="date-block">
                <div class="date-label">Date of Completion</div>
                <div class="date-value">{{ $certificate->issued_at->format('F j, Y') }}</div>
            </div>
        </div>
    </div>

</body>

</html>
