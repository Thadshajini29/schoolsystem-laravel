<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card - {{ $student->student_name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');
        
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 40px;
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .no-print-area {
            position: fixed;
            top: 20px;
            right: 20px;
        }

        .btn-print {
            background: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .id-card {
            width: 350px;
            height: 540px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
            text-align: center;
        }

        .header-accent {
            height: 140px;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            padding-top: 25px;
        }

        .school-logo {
            color: white;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .student-photo-container {
            position: relative;
            margin-top: -70px;
        }

        .student-photo {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            background: #eee;
        }

        .card-body {
            padding: 30px 20px;
        }

        .student-name {
            font-size: 22px;
            font-weight: 700;
            color: #2e3b4e;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .student-role {
            font-size: 14px;
            color: #4e73df;
            font-weight: 600;
            margin-bottom: 25px;
            letter-spacing: 2px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            text-align: left;
            margin-top: 20px;
        }

        .info-item {
            border-bottom: 1px solid #f1f1f1;
            padding-bottom: 8px;
        }

        .info-label {
            font-size: 10px;
            color: #99aab5;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 14px;
            color: #2e3b4e;
            font-weight: 600;
        }

        .qr-code {
            position: absolute;
            bottom: 30px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #f8f9fc;
            padding: 5px;
            border-radius: 5px;
        }

        .footer-accent {
            height: 10px;
            background: #4e73df;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        @media print {
            .no-print-area { display: none; }
            body { padding: 0; background: white; }
            .id-card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <div class="no-print-area">
        <button class="btn-print" onclick="window.print()">Print ID Card</button>
        <button class="btn-print" onclick="window.history.back()" style="background: #6c757d; margin-left: 10px;">Back</button>
    </div>

    <div class="id-card">
        <div class="header-accent">
            <div class="school-logo">SCHOOL SYSTEM</div>
            <div style="color: rgba(255,255,255,0.8); font-size: 10px; margin-top: 5px;">STUDENT IDENTIFICATION</div>
        </div>

        <div class="student-photo-container">
            <img src="{{ $student->file_path ? asset('storage/' . $student->file_path) : 'https://ui-avatars.com/api/?name=' . urlencode($student->student_name) . '&background=4e73df&color=fff&size=200' }}" 
                 class="student-photo" alt="{{ $student->student_name }}">
        </div>

        <div class="card-body">
            <div class="student-name">{{ $student->student_name }}</div>
            <div class="student-role">ID: {{ $student->admission_no }}</div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Grade / Class</div>
                    <div class="info-value">{{ $student->grade->grade_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Admission Date</div>
                    <div class="info-value">{{ $student->admission_date ?? 'Not Specified' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Current Academic Year</div>
                    <div class="info-value">{{ $student->academic_year ?? 'Default' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Emergency Contact</div>
                    <div class="info-value">{{ $student->phone_no ?? 'No Contact' }}</div>
                </div>
            </div>
        </div>

        <div class="footer-accent"></div>
    </div>
</body>
</html>
