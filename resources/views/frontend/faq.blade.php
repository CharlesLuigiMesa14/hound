@extends('layouts.front')

@section('content')
<style>
    /* Styles specific to this component */
    #faq-section {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #ffffff; /* Changed to white background */
        color: #333;
    }
    #faq-header {
        background: #8B0000; /* Custom color */
        color: #fff;
        padding: 5px;
        text-align: center;
    }
    .faq-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .faq-greeting {
        font-size: 20px;
        margin-bottom: 15px;
        text-align: center;
        padding: 15px;
        background-color: #CD5C5C;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        color: #fff;
    }
    .faq-search {
        margin-bottom: 20px;
        width: 100%;
    }
    .faq-search input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }
    .faq-categories {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }
    .faq-category {
        flex: 1;
        margin: 0 10px;
        padding: 15px;
        color: #8B0000;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.3s;
        border: 2px solid transparent;
    }
    .faq-category:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(139, 0, 0, 0.3);
        border: 2px solid #8B0000;
    }
    .faq-category.active {
        box-shadow: 0 0 10px rgba(139, 0, 0, 0.5);
        border: 2px solid #8B0000;
    }
    .faq-category i {
        display: block;
        font-size: 24px;
        margin-bottom: 5px;
    }
    .faq-item {
        margin: 15px 0;
        cursor: pointer;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
    }
    .faq-question {
        font-weight: bold;
        color: #8B0000;
    }
    .faq-answer {
        padding: 0 10px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, padding 0.4s ease;
        background-color: #f9f9f9;
        border-left: 4px solid #8B0000;
        margin-top: 5px;
    }
    .faq-answer.show {
        max-height: 500px; /* High max height for full visibility */
        padding: 0px 10px; /* Add padding when expanded */
    }
    .faq-answer ul {
        margin: 0; /* Remove default margin */
        padding-left: 20px; /* Indent bullet points */
    }
    .faq-item:hover {
        background: #f1f1f1;
    }
    .faq-answer p {
        margin: 5px 0; /* Add margin for paragraphs */
    }
    .faq-answer strong {
        color: #8B0000; /* Dark red for bold text */
    }
    .faq-answer em {
        font-style: italic; /* Italics for emphasis */
    }
</style>

<div id="faq-section">
    <header id="faq-header">
        <h5>Customer Service FAQs - Jewelry Shop</h5>
    </header>
    <div class="faq-container">
        <!-- Greeting Message -->
        <div class="faq-greeting">Hi, how can we help?</div>

        <!-- Search Bar -->
        <div class="faq-search">
            <input type="text" id="search" placeholder="Search FAQs..." onkeyup="searchFAQs()">
        </div>

        <div class="faq-categories">
            <div class="faq-category" onclick="filterFAQs('hot', this)">
                <i class="fas fa-fire"></i> Hot Questions
            </div>
            <div class="faq-category" onclick="filterFAQs('deals', this)">
                <i class="fas fa-tags"></i> Deals & Rewards
            </div>
            <div class="faq-category" onclick="filterFAQs('payments', this)">
                <i class="fas fa-credit-card"></i> Payments
            </div>
            <div class="faq-category" onclick="filterFAQs('shipping', this)">
                <i class="fas fa-shipping-fast"></i> Order Shipping
            </div>
            <div class="faq-category" onclick="filterFAQs('returns', this)">
                <i class="fas fa-undo"></i> Returns & Refunds
            </div>
            <div class="faq-category" onclick="filterFAQs('general', this)">
                <i class="fas fa-info-circle"></i> General
            </div>
        </div>

        <!-- FAQs -->
        <div class="faq-item" data-category="deals" onclick="toggleFAQ('faq1')">
            <div class="faq-question">How can I sign up for your rewards program?</div>
            <div class="faq-answer" id="faq1">
                <p>You can sign up for our rewards program by:</p>
                <ul>
                    <li><strong>Creating an account</strong> on our website.</li>
                    <li><strong>Automatically enrolling</strong> in the rewards program upon registration.</li>
                </ul>
                <p>Once enrolled, you'll start earning points for every purchase!</p>
            </div>
        </div>
        <div class="faq-item" data-category="deals" onclick="toggleFAQ('faq2')">
            <div class="faq-question">Do your rewards expire?</div>
            <div class="faq-answer" id="faq2">
                <p>Yes, rewards points expire after:</p>
                <ul>
                    <li><strong>12 months of inactivity.</strong></li>
                    <li>It's important to shop regularly or redeem your points before they expire.</li>
                </ul>
                <p><em>Keep an eye on your account to ensure you don’t lose any rewards!</em></p>
            </div>
        </div>
        <div class="faq-item" data-category="deals" onclick="toggleFAQ('faq3')">
            <div class="faq-question">Can I combine discounts and rewards on a single purchase?</div>
            <div class="faq-answer" id="faq3">
                <p>Yes, you can combine discounts and rewards by:</p>
                <ul>
                    <li><strong>Applying your rewards</strong> during the checkout process after selecting your discount.</li>
                </ul>
                <p>This ensures you get the best deal possible!</p>
            </div>
        </div>
        <div class="faq-item" data-category="deals" onclick="toggleFAQ('faq4')">
            <div class="faq-question">Are there any special promotions for members?</div>
            <div class="faq-answer" id="faq4">
                <p>Yes! Members receive:</p>
                <ul>
                    <li><strong>Exclusive access</strong> to special promotions.</li>
                    <li><strong>Early notifications</strong> for sales.</li>
                    <li><strong>Bonus rewards</strong> on select products.</li>
                </ul>
                <p><em>Make sure to check your email for these exciting offers!</em></p>
            </div>
        </div>
        <div class="faq-item" data-category="returns" onclick="toggleFAQ('faq5')">
            <div class="faq-question">What is your return policy for jewelry items?</div>
            <div class="faq-answer" id="faq5">
                <p>Our return policy allows you to:</p>
                <ul>
                    <li>Return jewelry items within <strong>30 days</strong> of delivery.</li>
                    <li>Ensure that the jewelry is <strong>unworn</strong> and in its original packaging.</li>
                </ul>
                <p>If you have any questions about the return process, feel free to reach out!</p>
            </div>
        </div>
        <div class="faq-item" data-category="general" onclick="toggleFAQ('faq6')">
            <div class="faq-question">How can I contact customer support for jewelry-related inquiries?</div>
            <div class="faq-answer" id="faq6">
                <p>You can reach our customer support team by:</p>
                <ul>
                    <li>Email: <strong>support@jewelryshop.com</strong></li>
                    <li>Phone: <strong>(123) 456-7890</strong> (Monday to Friday, 9 AM to 5 PM).</li>
                </ul>
                <p>We’re here to help with any inquiries you may have!</p>
            </div>
        </div>
        <div class="faq-item" data-category="payments" onclick="toggleFAQ('faq7')">
            <div class="faq-question">What payment methods do you accept for jewelry purchases?</div>
            <div class="faq-answer" id="faq7">
                <p>We accept all major credit cards, including:</p>
                <ul>
                    <li>Paypal</li>
                    <li>Cash on Delivery</li>
                    <li>Pay Maya (Coming Soon)</li>
                </ul>
                <p>We also accept <strong>PayPal</strong> and bank transfers for your convenience.</p>
            </div>
        </div>
        <div class="faq-item" data-category="payments" onclick="toggleFAQ('faq8')">
            <div class="faq-question">Can I use a gift card to make a purchase?</div>
            <div class="faq-answer" id="faq8">
                <p>Yes, you can use a gift card by:</p>
                <ul>
                    <li><strong>Entering your gift card information</strong> during the checkout process.</li>
                </ul>
                <p><em>Gift cards are a great way to treat yourself or someone special!</em></p>
            </div>
        </div>
        <div class="faq-item" data-category="payments" onclick="toggleFAQ('faq9')">
            <div class="faq-question">Is my payment information secure when I make a purchase?</div>
            <div class="faq-answer" id="faq9">
                <p>Absolutely! We use:</p>
                <ul>
                    <li><strong>Industry-standard encryption technologies</strong> to ensure your payment information is secure during transmission.</li>
                    <li>Your privacy and security are our top priorities.</li>
                </ul>
                <p><em>Shop with confidence knowing your information is safe!</em></p>
            </div>
        </div>
        <div class="faq-item" data-category="shipping" onclick="toggleFAQ('faq10')">
            <div class="faq-question">What is your shipping policy for jewelry orders?</div>
            <div class="faq-answer" id="faq10">
                <p>We offer free standard shipping on all jewelry orders within:</p>
                <ul>
                    <li><strong>The contiguous United States.</strong></li>
                    <li>Expedited shipping options are available for an additional fee.</li>
                </ul>
                <p>Expect your beautiful jewelry to arrive safely and on time!</p>
            </div>
        </div>
        <div class="faq-item" data-category="returns" onclick="toggleFAQ('faq11')">
            <div class="faq-question">Do you offer a satisfaction guarantee for your jewelry products?</div>
            <div class="faq-answer" id="faq11">
                <p>Yes, we stand behind the quality and craftsmanship of our jewelry. If you are not completely satisfied, you can:</p>
                <ul>
                    <li><strong>Return the item within 30 days for a full refund.</strong></li>
                </ul>
                <p>We want you to love your purchase!</p>
            </div>
        </div>
        <div class="faq-item" data-category="general" onclick="toggleFAQ('faq12')">
            <div class="faq-question">How do I care for my jewelry items?</div>
            <div class="faq-answer" id="faq12">
                <p>To care for your jewelry, we recommend:</p>
                <ul>
                    <li><strong>Storing it in a cool, dry place.</strong></li>
                    <li><strong>Avoiding exposure to harsh chemicals.</strong></li>
                    <li><strong>Cleaning gently with a soft cloth.</strong></li>
                </ul>
                <p>For detailed care instructions, refer to the information provided with your purchase.</p>
            </div>
        </div>
        <div class="faq-item" data-category="general" onclick="toggleFAQ('faq13')">
            <div class="faq-question">Do you offer gift wrapping for jewelry purchases?</div>
            <div class="faq-answer" id="faq13">
                <p>Yes, we offer complimentary gift wrapping for all jewelry purchases. You can:</p>
                <ul>
                    <li><strong>Select the gift wrapping option</strong> during checkout.</li>
                </ul>
                <p>We will package your item beautifully, making it a perfect gift!</p>
            </div>
        </div>
        <div class="faq-item" data-category="shipping" onclick="toggleFAQ('faq14')">
            <div class="faq-question">Can I track my order after it has been shipped?</div>
            <div class="faq-answer" id="faq14">
                <p>Yes, once your order has shipped, you will receive:</p>
                <ul>
                    <li><strong>An email with a tracking number.</strong></li>
                    <li><strong>A link to track your package online.</strong></li>
                </ul>
                <p><em>Stay updated on your order's journey!</em></p>
            </div>
        </div>
        <div class="faq-item" data-category="shipping" onclick="toggleFAQ('faq15')">
            <div class="faq-question">Do you offer international shipping?</div>
            <div class="faq-answer" id="faq15">
                <p>Yes, we offer international shipping to select countries. Please check our shipping policy for:</p>
                <ul>
                    <li><strong>Details on countries we ship to.</strong></li>
                    <li><strong>Any associated fees.</strong></li>
                </ul>
                <p>Your beautiful jewelry can travel anywhere!</p>
            </div>
        </div>
        <div class="faq-item" data-category="returns" onclick="toggleFAQ('faq16')">
            <div class="faq-question">How do I initiate a return for a jewelry item?</div>
            <div class="faq-answer" id="faq16">
                <p>To initiate a return, please:</p>
                <ul>
                    <li><strong>Contact our customer support team</strong> within 30 days of receiving your item.</li>
                </ul>
                <p>They will guide you through the return process.</p>
            </div>
        </div>
        <div class="faq-item" data-category="returns" onclick="toggleFAQ('faq17')">
            <div class="faq-question">When will I receive my refund after returning an item?</div>
            <div class="faq-answer" id="faq17">
                <p>Refunds are processed within:</p>
                <ul>
                    <li><strong>5-7 business days</strong> after we receive your returned item.</li>
                </ul>
                <p>You will receive a confirmation email once your refund is issued.</p>
            </div>
        </div>
    </div>
</div>
@include('layouts.inc.frontfooter')
<script>
    let currentCategory = 'hot'; // Default category on load

    function toggleFAQ(faqId) {
        const answer = document.getElementById(faqId);
        answer.classList.toggle('show'); // Toggle the show class

        // Set height to accommodate content
        if (answer.classList.contains('show')) {
            answer.style.maxHeight = answer.scrollHeight + "px"; // Set max height to the scroll height
        } else {
            answer.style.maxHeight = "0"; // Collapse
        }
    }

    function filterFAQs(category, element) {
        const faqs = document.getElementsByClassName("faq-item");
        const categories = document.getElementsByClassName("faq-category");

        // Remove active class from all categories
        for (let cat of categories) {
            cat.classList.remove("active");
        }

        // Add active class to the selected category
        element.classList.add("active");
        
        // Update current category
        currentCategory = category;

        // Filter FAQs
        for (let faq of faqs) {
            if (faq.getAttribute('data-category') === category || 
                category === 'hot' && (faq.getAttribute('data-category') === 'returns' || faq.getAttribute('data-category') === 'payments')) {
                faq.style.display = "block"; // Show the relevant questions
            } else {
                faq.style.display = "none"; // Hide others
                faq.querySelector('.faq-answer').classList.remove('show'); // Ensure answers are collapsed
                faq.querySelector('.faq-answer').style.maxHeight = "0"; // Reset height
            }
        }
    }

    function searchFAQs() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const faqs = document.getElementsByClassName('faq-item');

        // If the input is empty, reset to current category
        if (filter === "") {
            filterFAQs(currentCategory, document.querySelector(`.faq-category.active`));
        } else {
            // Filter FAQs based on input
            for (let faq of faqs) {
                const question = faq.querySelector('.faq-question').textContent.toLowerCase();
                if (question.includes(filter)) {
                    faq.style.display = "block"; // Show matching questions
                } else {
                    faq.style.display = "none"; // Hide non-matching questions
                    faq.querySelector('.faq-answer').classList.remove('show'); // Ensure answers are collapsed
                    faq.querySelector('.faq-answer').style.maxHeight = "0"; // Reset height
                }
            }
        }
    }

    // Initialize the FAQ section to show the hot questions by default
    document.addEventListener("DOMContentLoaded", function() {
        filterFAQs(currentCategory, document.querySelector('.faq-category'));
    });
</script>
@endsection