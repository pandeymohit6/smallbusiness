@extends('frontend.layouts.app')

@section('content')
    <div class="registration-container-reg-buy" style="text-align: center;">
        <div class="page-header-reg-buy">
            <h1>Registration Confirmation</h1>
            <div class="accent-line-reg-buy"></div>
        </div>

        <div style="padding: 40px 20px; background: #f9fafb; border-radius: 8px; margin: 20px 0;">
            <div style="font-size: 48px; margin-bottom: 20px;">✓</div>
            <h2 style="color: #10b981; margin-bottom: 20px;">Registration Successful!</h2>
            <p style="font-size: 16px; color: #4b5563; margin-bottom: 10px;">
                Thank you for registering, <strong>{{ $registration->firstname }} {{ $registration->lastname }}</strong>!
            </p>
            <p style="font-size: 14px; color: #6b7280; margin-bottom: 30px;">
                A confirmation email has been sent to <strong>{{ $registration->email }}</strong>
            </p>

            <div style="background: white; padding: 20px; border-radius: 6px; margin: 20px 0; text-align: left; max-width: 500px; margin-left: auto; margin-right: auto;">
                <h3 style="margin-bottom: 15px; color: #1f2937;">Registration Details</h3>
                <p style="margin: 10px 0;"><strong>Email:</strong> {{ $registration->email }}</p>
                <p style="margin: 10px 0;"><strong>Name:</strong> {{ $registration->firstname }} {{ $registration->lastname }}</p>
                <p style="margin: 10px 0;"><strong>Phone:</strong> {{ $registration->phone }}</p>
                <p style="margin: 10px 0;"><strong>Country:</strong> {{ $registration->country->name ?? 'N/A' }}</p>
                <p style="margin: 10px 0;"><strong>Buyer Type:</strong> {{ $registration->buyerType->name ?? 'N/A' }}</p>
                <p style="margin: 10px 0;"><strong>Experience:</strong> {{ $registration->buyerExperience->name ?? 'N/A' }}</p>
                <p style="margin: 10px 0;"><strong>Status:</strong> <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px;">{{ ucfirst($registration->status) }}</span></p>
            </div>

            <div style="margin-top: 30px;">
                <a href="{{ route('home') }}" class="btn btn-primary" style="display: inline-block; background: #3b82f6; color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
@endsection
