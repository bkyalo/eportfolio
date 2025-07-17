@extends('layouts.app')

@push('styles')
<style>
    .thank-you-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }
    
    .thank-you-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 3rem 2rem;
        max-width: 600px;
        width: 100%;
        text-align: center;
        position: relative;
        overflow: hidden;
        border: none;
    }
    
    .checkmark-circle {
        width: 100px;
        height: 100px;
        margin: 0 auto 2rem;
        position: relative;
        animation: scaleIn 0.5s ease-out;
    }
    
    .checkmark {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: block;
        stroke-width: 4;
        stroke: #4CAF50;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #4CAF50;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    
    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    
    .thank-you-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: fadeInUp 0.6s ease-out;
    }
    
    .thank-you-message {
        font-size: 1.25rem;
        color: #4a5568;
        margin-bottom: 2.5rem;
        line-height: 1.6;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        animation: fadeInUp 0.6s ease-out 0.2s;
        animation-fill-mode: both;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        animation: fadeInUp 0.6s ease-out 0.4s;
        animation-fill-mode: both;
    }
    
    .btn {
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    
    .btn-outline-primary {
        background: transparent;
        border: 2px solid #4f46e5;
        color: #4f46e5;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(79, 70, 229, 0.2);
    }
    
    .btn:active {
        transform: translateY(0);
    }
    
    .decoration {
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(124, 58, 237, 0) 70%);
    }
    
    .decoration-1 {
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
    }
    
    .decoration-2 {
        bottom: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
    }
    
    @keyframes scaleIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from { 
            opacity: 0;
            transform: translateY(20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }
    
    @keyframes scale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.1, 1.1, 1); }
    }
    
    @keyframes fill {
        100% { box-shadow: inset 0px 0px 0px 50px rgba(76, 175, 80, 0); }
    }
    
    @media (max-width: 576px) {
        .thank-you-card {
            padding: 2rem 1.5rem;
        }
        
        .thank-you-title {
            font-size: 2rem;
        }
        
        .thank-you-message {
            font-size: 1.1rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="thank-you-container">
    <div class="container">
        <div class="thank-you-card mx-auto">
            <!-- Decorative elements -->
            <div class="decoration decoration-1"></div>
            <div class="decoration decoration-2"></div>
            
            <!-- Animated checkmark -->
            <div class="checkmark-circle">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            
            <h1 class="thank-you-title">Message Sent Successfully!</h1>
            <p class="thank-you-message">
                Thank you for reaching out! I've received your message and will get back to you as soon as possible. 
                Your thoughts are important to me.
            </p>
            
            <div class="action-buttons">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i> Return Home
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                    <i class="fas fa-paper-plane me-2"></i> Send Another Message
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add a subtle animation to the card on load
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.querySelector('.thank-you-card');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>
@endpush
