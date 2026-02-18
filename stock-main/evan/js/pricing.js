// Pricing Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializePlanButtons();
    initializeFeatureComparison();
});

// Plan Button Handlers
function initializePlanButtons() {
    const planButtons = document.querySelectorAll('[data-plan]');
    
    planButtons.forEach(button => {
        button.addEventListener('click', function() {
            const plan = this.getAttribute('data-plan');
            handlePlanSelection(plan);
        });
    });
}

// Handle Plan Selection
function handlePlanSelection(plan) {
    const planName = {
        'basic': 'Basic Plan (5,000 Rwf/month)',
        'pro': 'Pro Plan (1,500 Rwf/month) - Free 14-day Trial',
        'enterprise': 'Enterprise Plan (Custom Pricing)'
    };

    const messages = {
        'basic': 'Redirecting to sign up for Basic plan...',
        'pro': 'Starting your 14-day free trial of Pro plan...',
        'enterprise': 'Connecting you with our sales team...'
    };

    console.log(`Selected plan: ${plan}`);
    alert(`${messages[plan]}\n\n${planName[plan]}`);
    
    // In a real application, redirect to signup/checkout
    // window.location.href = `/signup?plan=${plan}`;
}

// Feature Comparison (optional expansion)
function initializeFeatureComparison() {
    // This could be expanded to show a comparison table
    // triggered by a "Compare Plans" button
}

// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href !== '#' && document.querySelector(href)) {
            e.preventDefault();
            const target = document.querySelector(href);
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
