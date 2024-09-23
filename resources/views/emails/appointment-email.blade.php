<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Mechanic Appointment Confirmation</title>
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans text-gray-800 bg-gray-100">
    <div class="max-w-2xl mx-auto my-8 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white text-center">Your Mechanic Appointment Confirmation</h1>
        </div>

        <div class="p-6">
            <p class="mb-4">Dear Valued Customer,</p>
            <p class="mb-4">Your mechanic reservation is currently in <span class="font-bold text-orange-500 uppercase">{{ $appointment->status }}</span> status.</p>
            <p class="mb-6">One of our team members will contact you within 2-3 hours to confirm the reservation details.</p>

            <div class="bg-gray-100 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-semibold mb-4">Reservation Details</h2>
                <p class="mb-2"><strong>Reservation No:</strong> <span class="text-blue-600">{{ $appointment->appointment_number }}</span></p>
                <p class="mb-2"><strong>Appointment Date & Time:</strong> <span class="text-blue-600">{{ Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }} ({{ $appointment->appointment_time }})</span></p>
                <p class="mb-2"><strong>Vehicle:</strong> <span class="text-blue-600">{{ $appointment->car->car_details }}</span></p>
                <p class="mb-2"><strong>Service Type:</strong> <span class="text-blue-600">{{ $appointment->service_type }}</span></p>
            </div>

            <p class="mb-4">To get updates about your reservations and job services, please <a href="https://mechanic.fly.dev/customer/login" class="text-blue-600 underline">log in to your account</a>.</p>

            <p class="mb-4">If you have any questions or need to make changes to your appointment, please don't hesitate to contact us.</p>

            <p class="mb-6">Thank you for choosing our services.</p>

            <p class="mb-2">Best regards,<br>Your Mechanic Team</p>
        </div>

        <div class="bg-gray-200 px-6 py-4 text-center text-sm text-gray-600">
            <p class="mb-2">This is an automated message. Please do not reply to this email.</p>
            <p>&copy; 2024 Your Mechanic Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>