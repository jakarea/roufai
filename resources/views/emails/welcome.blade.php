<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Rouf AI Academy</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Welcome to Rouf AI Academy! 🎉</h1>
        </div>

        <!-- Content -->
        <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px;">
            <p style="font-size: 16px; margin-bottom: 20px;">
                Dear <strong>{{ $user->name }}</strong>,
            </p>

            <p style="font-size: 16px; margin-bottom: 20px;">
                Congratulations on joining Rouf AI Academy! We're thrilled to have you as part of our learning community.
            </p>

            <p style="font-size: 16px; margin-bottom: 20px;">
                Your account has been successfully created with the following details:
            </p>

            <div style="background: #ffffff; padding: 15px; border-left: 4px solid #667eea; margin-bottom: 20px;">
                <p style="margin: 5px 0;"><strong>Name:</strong> {{ $user->name }}</p>
                <p style="margin: 5px 0;"><strong>Email:</strong> {{ $user->email }}</p>
                <p style="margin: 5px 0;"><strong>Role:</strong> Student</p>
            </div>

            <h2 style="color: #667eea; font-size: 20px; margin-bottom: 15px;">What's Next?</h2>

            <ul style="font-size: 16px; line-height: 1.8;">
                <li>Browse our <a href="{{ route('courses') }}" style="color: #667eea; text-decoration: none; font-weight: bold;">course catalog</a> and find the perfect course for you</li>
                <li>Enroll in free courses instantly or submit requests for paid courses</li>
                <li>Access your enrolled courses from your <a href="{{ route('student.dashboard') }}" style="color: #667eea; text-decoration: none; font-weight: bold;">student dashboard</a></li>
                <li>Track your progress and earn certificates upon completion</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('student.dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;">
                    Go to Student Dashboard
                </a>
            </div>

            <p style="font-size: 16px; margin-bottom: 10px;">
                If you have any questions, feel free to reach out to our support team.
            </p>

            <p style="font-size: 16px;">
                Happy learning! 🚀
            </p>

            <p style="font-size: 16px; margin-bottom: 0;">
                <strong>Team Rouf AI Academy</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 20px; color: #777; font-size: 12px;">
            <p style="margin: 5px 0;">
                © {{ date('Y') }} Rouf AI Academy. All rights reserved.
            </p>
            <p style="margin: 5px 0;">
                You're receiving this email because you created an account on Rouf AI Academy.
            </p>
        </div>
    </div>
</body>
</html>
