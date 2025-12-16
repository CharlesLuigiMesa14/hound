@extends('layouts.front')
  


@section('content')
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f5f5f5;
}



.header {
  text-align: center;

}

.logo {
  max-width: 200px;
  margin-bottom: 20px;
}

h1 {
  color: #333;
  font-size: 32px;
}

.policy-section {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  padding: 40px;
  margin-bottom: 10px;
  opacity: 0; /* Initial opacity */
  transform: translateX(100px); /* Start off-screen */
}

.policy-section h2 {
  color: darkred; /* Changed title color to dark red */
  font-size: 24px;
  margin-bottom: 20px;
}

.return-content,
.refund-content,
.shipping-content,
.contact-content {
  line-height: 1.6;
}

.return-content p,
.refund-content p,
.shipping-content p,
.contact-content p {
  margin-bottom: 20px;
}

.return-content ul,
.refund-content ul,
.shipping-content ul,
.contact-content ul {
  margin-left: 20px;
  margin-bottom: 20px;
}

.late-refunds {
  border-top: 1px solid #eee;
  padding-top: 20px;
  margin-top: 20px;
}

.late-refunds h3 {
  color: #333;
  font-size: 18px;
}

a {
  color: #007bff;
  text-decoration: none;
}

a:hover {
  color: #0056b3;
}
</style>

  <div class="container" >
    <div class="header">
      <img src="assets/images/return.png" alt="Hound Men's Jewelry Shop" class="logo" style="max-width: 1300px; border-radius: 5px;">
    </div>

    <div class="policy-section">
      <h2><i class="fas fa-box"></i> Returns</h2>
      <div class="return-content">
        <p>At Hound Men's Jewelry Shop, we want you to love your purchase. If you find that your order does not meet your expectations, we are happy to assist you with the return process. Returns are accepted under the following conditions:</p>
        <ul>
          <li>Items must be returned within 30 days of delivery.</li>
          <li>Jewelry must be unused, unworn, and in its original packaging with all tags attached.</li>
          <li>Original packaging, including boxes, pouches, and certificates, must accompany the return.</li>
        </ul>
        <p>To begin a return, please contact us at <a href="mailto:houndtip@gmail.com">houndtip@gmail.com</a>. Our team will provide you with the necessary instructions and support throughout the process.</p>
      </div>
    </div>

    <div class="policy-section">
      <h2><i class="fas fa-money-check-alt"></i> Refunds</h2>
      <div class="refund-content">
        <p>Refunds are processed for items that comply with our return policy. To ensure a smooth refund experience, please provide the following:</p>
        <ul>
          <li>A receipt or proof of purchase.</li>
          <li>Confirmation that the item meets the return criteria outlined above.</li>
        </ul>
        <p>Once your return is approved, we will process your refund promptly. The credit will be applied to your original payment method, typically within a few business days. Please note that shipping fees are non-refundable unless the item was defective or sent in error.</p>
        <div class="late-refunds">
          <h3>Late or Missing Refunds</h3>
          <p>If you haven't received a refund yet, please take the following steps:</p>
          <ul>
            <li>Check your bank account for any pending transactions.</li>
            <li>Contact your credit card company; it may take time for the refund to post.</li>
            <li>Reach out to your bank; processing times may vary.</li>
          </ul>
          <p>If you have completed these steps and still have not received your refund, please contact us at <a href="mailto:houndtip@gmail.com">houndtip@gmail.com</a>.</p>
        </div>
      </div>
    </div>

    <div class="policy-section">
      <h2><i class="fas fa-shipping-fast"></i> Shipping Policy</h2>
      <div class="shipping-content">
        <p>We strive to process and ship all orders within 1-2 business days. Once your order has been shipped, a tracking number will be provided to you via email, allowing you to monitor your shipment's progress. If you encounter any issues with your shipment, please reach out to us immediately for assistance.</p>
        <p>We offer reliable shipping options to ensure your jewelry arrives safely. Here are some key points regarding our shipping practices:</p>
        <ul>
          <li>Free standard shipping on all orders within the Philippines.</li>
          <li>Expedited shipping options are available upon request for an additional fee.</li>
          <li>Tracking information will be provided once your order ships.</li>
        </ul>
        <p>We take great care to package our products securely, minimizing the risk of damage during transit. Your satisfaction is important to us, and we are committed to ensuring a positive shopping experience.</p>
      </div>
    </div>

    <div class="policy-section">
      <h2><i class="fas fa-phone-alt"></i> Contact Us</h2>
      <div class="contact-content">
        <p>If you have any questions or concerns regarding our return or shipping policies, please don't hesitate to reach out to our customer support team. We are here to help you!</p>
        <ul>
          <li><strong>Email:</strong> <a href="mailto:houndtip@gmail.com">houndtip@gmail.com</a></li>
          <li><strong>Phone:</strong> +63 953 402 0070</li>
          <li><strong>Address:</strong> Hound, General Aguinaldo Ave, Cubao, Quezon City, Metro Manila</li>
          <li><strong>Operating Hours:</strong> 9 AM - 6 PM, Monday to Saturday</li>
        </ul>
        <p>Your feedback is invaluable to us, and we encourage you to share your thoughts to help us improve our services.</p>
      </div>
    </div>
  </div>
  @include('layouts.inc.frontfooter')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.policy-section');
  
    function showSection(section) {
      section.style.transition = 'opacity 1s, transform 1s'; // Set the duration to 1s
      section.style.opacity = '1';
      section.style.transform = 'translateX(0)';
      section.classList.add('animated');
    }
  
    function handleScroll() {
      sections.forEach(section => {
        const rect = section.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0 && !section.classList.contains('animated')) {
          showSection(section);
        }
      });
    }
  
    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Initial check in case sections are already in view
  });
  </script>

@endsection