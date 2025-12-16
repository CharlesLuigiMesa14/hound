@extends('layouts.front')


@section('content')
<style> 
    body {
    background-color: #f4f4f4; /* Light gray background */
    color: #333; /* Dark gray font color */
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
}

.main-container {
    display: flex;
    padding: 20px;
}

.sidebar {
    background-color: #ffffff; /* White sidebar */
    padding: 50px;
    width: 310px;
    border-right: 1px solid #ccc; /* Border for separation */
    position: sticky; /* Fix sidebar while scrolling */
    top: 0; /* Stick to the top */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Drop shadow for sidebar */
}

.sidebar h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: #8B0000; /* Dark red for sidebar title */
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar a {
    display: flex;
    align-items: center;
    padding: 12px; /* Padding for better click area */
    color: #333; /* Default dark gray text color */
    text-decoration: none;
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Icon styles */
.sidebar a i {
    margin-right: 10px; /* Space between icon and text */
}

/* Hover effect */
.sidebar a:hover {
    background-color: #8B0000; /* Red background on hover */
    color: #ffffff; /* White text on hover */
}

/* Active link styling */
.sidebar a.active {
    color: #8B0000; /* Dark red text for active link */
    background-color: #e0e0e0; /* Dirty white background for active link */
}

main {
    flex-grow: 1;
    padding: 0 20px;
}

section {
    display: none; /* Hide all sections by default */
    margin-bottom: 40px;
}

section.active {
    display: block; /* Show the active section */
}

h2 {
    border-bottom: 2px solid #e6e6e6; /* Underline for section titles */
    padding-bottom: 10px;
    color: #8B0000; /* Dark red for section titles */
}

.section-container {
    background-color: #ffffff; /* White background for content sections */
    padding: 40px;
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Drop shadow for content sections */
}

.section-image {
    max-width: 100%; /* Responsive images */
    height: auto; /* Maintain aspect ratio */
    margin-top: 20px; /* Space above images */
}

#meet-our-team {
    padding: 30px;
    text-align: center; /* Center text in the section */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Drop shadow for team section */
    background-color: #ffffff;
}

.team-container {
    display: flex; /* Use flexbox to arrange items */
    justify-content: center; /* Center the items horizontally */
    flex-wrap: wrap; /* Allow items to wrap in smaller screens */
    gap: 20px; /* Space between the items */
    
}

.team-member {
    background-color: #ffffff; /* Light background for team members */
    border-radius: 10px; /* Rounded corners */
    overflow: hidden;
    text-align: center;
    transition: transform 0.3s ease;
    flex: 1 1 calc(20% - 20px); /* Set the width to 20% for five columns, minus gap */
    max-width: 200px; /* Ensure a maximum width */
    height: 400px; /* Set a fixed height for team members */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Drop shadow */
}

@media (max-width: 1200px) {
    .team-member {
        flex: 1 1 calc(25% - 20px); /* Four columns on medium screens */
    }
}

@media (max-width: 900px) {
    .team-member {
        flex: 1 1 calc(33.33% - 20px); /* Three columns on smaller screens */
    }
}

@media (max-width: 600px) {
    .team-member {
        flex: 1 1 calc(50% - 20px); /* Two columns on small screens */
    }
}

@media (max-width: 400px) {
    .team-member {
        flex: 1 1 100%; /* One column on very small screens */
    }
}

.team-member:hover {
    transform: scale(1.05); /* Scale effect on hover */
}

.team-member img {
    width: 100%; /* Ensure the image takes the full width of its container */
    height: 300px; /* Maintain the aspect ratio */
    object-fit: cover; /* Cover the area without distortion */
}

.team-member h3 {
    color: #333;
    font-size: 18px;
    margin: 10px 0;
}

.team-member p {
    color: #555;
    font-size: 14px;
    margin-bottom: 10px;
}

.team-member .social-links a {
    color: #333;
    font-size: 18px;
    margin: 0 5px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.team-member .social-links a:hover {
    color: #007BFF; /* Change color on hover */
}

hr {
    border: 0; /* Remove default border */
    height: 1px; /* Set height */
    background-color: rgba(154, 154, 154, 0.1); /* Low-opacity #333 */
    margin: 20px 0; /* Space above and below */
}
</style>


<div class="main-container">

<nav class="sidebar">

<h2>About Us</h2>

<ul>

<li><a href="#" onclick="showSection('about-company')"><i class="fas fa-info-circle"></i> About Our Company</a></li>

<li><a href="#" onclick="showSection('our-mission-vision')"><i class="fas fa-bullseye"></i> Our Mission & Vision</a></li>

<li><a href="#" onclick="showSection('our-values')"><i class="fas fa-thumbs-up"></i> Our Values</a></li>

<li><a href="#" onclick="showSection('our-culture')"><i class="fas fa-users"></i> Our Culture</a></li>

<li><a href="#" onclick="showSection('meet-our-team')"><i class="fas fa-users-cog"></i> Meet Our Team</a></li>

</ul>

</nav>

<main>

    <section id="about-company" class="active">
        <div class="section-container" style="max-width: 1050px; margin: 0 auto; text-align: justify; background: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 30px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <h2 style="text-align: left; color: #8B0000; margin-bottom: 20px; font-size: 2em; line-height: 2.0;">About Our Company</h2>
            
            <img src="assets/images/comp.png" alt="Company Landscape" style="width: 100%; border-radius: 5px; margin-bottom: 30px;">

            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-building fa-2x" style="color: darkred; display: block; margin: 0 auto;"></i>
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Established</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">Founded in 2020, we have swiftly established ourselves as a reputable name in men's accessories, renowned for our commitment to quality and innovative design.</p>
                </div>
                <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-globe fa-2x" style="color: darkred; display: block; margin: 0 auto;"></i>
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Global Reach</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">Our products are available in over 20 countries worldwide, catering to a diverse clientele that appreciates craftsmanship combined with contemporary design.</p>
                </div>
                <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-award fa-2x" style="color: darkred; display: block; margin: 0 auto;"></i>
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Awards</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">Our dedication to excellence in design and sustainability has earned us numerous accolades, reflecting our unwavering commitment to quality and innovation.</p>
                </div>
                <div style="flex: 1; min-width: 220px; background: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-heart fa-2x" style="color: darkred; display: block; margin: 0 auto;"></i>
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Customer Focus</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">We prioritize customer satisfaction and actively seek feedback, ensuring that our products evolve to meet the dynamic needs of our clientele.</p>
                </div>
            </div>
    
            <hr style="margin: 40px 0;">
    
            <div style="margin-top: 40px; text-align: justify;">
                <h3 style="color: darkred; margin-bottom: 10px; font-size: 1.5em; line-height: 2.0;">Our Journey</h3>
                <p style="font-size: 1em; line-height: 2.0; text-indent: 30px;">
                    At Hound Jewelry, we believe that our narrative is as significant as the products we offer. Our journey began with a singular vision: to provide men with accessories that not only enhance their personal style but also embody their values. 
                    From our humble beginnings of handcrafting unique pieces, we quickly captured the attention of discerning customers who appreciate artistry and authenticity. Today, we have evolved into a thriving enterprise that remains steadfastly committed to our foundational principles of quality, craftsmanship, and sustainability. 
                    Our team is fueled by passion and dedication, striving to cultivate a culture of integrity and excellence in every facet of our operations.
                </p>
            </div>
    
            <div style="margin-top: 40px; text-align: justify;">
                <h3 style="color: darkred; margin-bottom: 10px; font-size: 1.5em; line-height: 2.0;">Our Commitment</h3>
                <p style="font-size: 1em; line-height: 2.0; text-indent: 30px;">
                    We continuously explore innovative techniques and sustainable materials to enhance our product offerings, ensuring that we not only meet but exceed the expectations of our valued customers. Our commitment extends beyond mere transactions; we aim to create lasting relationships built on trust and mutual respect with our clients. 
                    As we look to the future, we remain devoted to our mission of redefining men's accessories, fostering a community that celebrates individuality, creativity, and responsible craftsmanship. We envision a brand that resonates with customers on a personal level, becoming synonymous with style, integrity, and excellence.
                </p>
            </div>
    
            <div style="margin-top: 40px; text-align: justify;">
                <h3 style="color: darkred; margin-bottom: 10px; font-size: 1.5em; line-height: 2.0;">Innovation and Design</h3>
                <p style="font-size: 1em; line-height: 2.0; text-indent: 30px;">
                    At Hound Jewelry, innovation drives our design philosophy. We are constantly seeking new ideas and inspirations to create accessories that are not only stylish but also functional. Our design team collaborates closely with skilled artisans to bring unique concepts to life, ensuring that each piece reflects our commitment to creativity and quality. 
                    By integrating contemporary trends with timeless elegance, our collections cater to the modern man who values both aesthetic appeal and practicality. We are dedicated to pushing the boundaries of design while maintaining the high standards our customers have come to expect.
                </p>
            </div>
    
            <div style="margin-top: 40px; text-align: justify;">
                <h3 style="color: darkred; margin-bottom: 10px; font-size: 1.5em; line-height: 2.0;">Our Story</h3>
                <p style="font-size: 1em; line-height: 2.0; text-indent: 30px;">
                    Our story is one of passion, dedication, and a relentless pursuit of excellence. It began when our founder, driven by a love for craftsmanship and a desire to fill a gap in the market, started creating unique accessories that spoke to the male audience. From the very beginning, the focus was on quality over quantity, ensuring that each piece was crafted with care and attention to detail.
                    As we grew, so did our vision. We wanted to create a brand that not only offered stylish products but also represented values such as sustainability and ethical production. This commitment is reflected in every item we create, from sourcing materials responsibly to ensuring our manufacturing processes respect both people and the planet.
                    By actively engaging with our customers, we have been able to refine our offerings and expand our reach, making our products accessible to a global audience. We value feedback and see it as an essential part of our growth, allowing us to remain attuned to the needs and preferences of our clientele.
                    Over the years, we have faced challenges, but each obstacle has only fueled our determination to succeed. Our journey is a testament to the belief that with hard work, integrity, and a focus on quality, it is possible to create a brand that resonates with customers on a deeper level. 
                    Today, Hound Jewelry is not just a business; it's a community of like-minded individuals who appreciate the beauty of craftsmanship and the importance of personal style. We invite you to be a part of our story as we continue to innovate, inspire, and redefine what it means to wear accessories that truly represent you.
                </p>
            </div>
        </div>
    </section>
    
    <section id="our-mission-vision">
        <div class="section-container" style="max-width: 1050px; margin: 0 auto; text-align: justify; background: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 30px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <h2 style="color: #8B0000; margin-bottom: 20px; font-size: 2em; line-height: 2.0;">Our Mission & Vision</h2>
            <img src="assets/images/mission.png" alt="Our Mission and Vision" class="section-image" style="width: 100%; max-width: 950px; display: block; margin: 20px auto; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <div style="margin-top: 40px;">
                <h3 style="color: darkred; margin-bottom: 10px; font-size: 1.5em; line-height: 2.0;">Our Mission</h3>
                <p style="font-size: 1em; line-height: 2.0;">
                    At <span class="highlight">Hound Jewelry</span>, our mission is to transform the landscape of men’s accessories by harmonizing timeless craftsmanship with contemporary design. We strive to empower men to express their individuality through distinctive pieces that reflect their unique style and enhance their confidence.
                    We are committed to creating high-quality accessories that elevate personal style while resonating with the values of authenticity and integrity. Our products are designed to inspire confidence, encouraging men to embrace their uniqueness and express themselves freely.
                    We believe in the power of storytelling through accessories, where each piece carries a narrative that connects with the wearer’s journey. By embracing innovation and sustainability, we aim to craft products that are not only stylish but also environmentally responsible.
                </p>
                <p style="font-size: 1em; line-height: 2.0;">
                    Our mission extends to fostering a culture of inclusivity, where every man feels represented and empowered. We actively seek to engage with our community, encouraging feedback and collaboration to continuously improve our offerings.
                    We also prioritize ethical sourcing and sustainable practices in our production processes, ensuring that our impact on the planet is positive. Our commitment to quality craftsmanship ensures that each piece is not just an accessory, but a lasting statement of style and values.
                </p>
            </div>
    
            <hr>
            <img src="assets/images/vision.png" alt="Our Mission and Vision" class="section-image" style="width: 100%; max-width: 950px; display: block; margin: 20px auto; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <div style="margin-top: 40px;">
                <h3 style="color: darkred; margin-bottom: 10px; font-size: 1.5em; line-height: 2.0;">Our Vision</h3>
                <p style="font-size: 1em; line-height: 2.0;">
                    We envision a future where men confidently embrace their personal style, breaking free from conventional norms and exploring new dimensions of self-expression. <span class="highlight">Hound Jewelry</span> aspires to be a leading name in men’s accessories, celebrated for innovative designs that blend tradition with modernity.
                    Our vision includes creating a global community where men feel empowered in their fashion choices, fostering an environment that encourages creativity and individuality. We aim to inspire change in the industry by setting trends that challenge stereotypes and promote authentic self-expression.
                    Central to our vision is a commitment to sustainable practices, ensuring our products benefit both our customers and the environment. We strive to build a brand that resonates deeply with our customers, advocating for style, integrity, and ethical consumption.
                </p>
            </div>
    
            <p style="font-size: 1em; line-height: 2.0;">
                Located in Anonas, Cubao, Quezon City, we are dedicated to producing accessories that exemplify exceptional quality and artistry. We prioritize the use of ethically sourced materials, ensuring our practices contribute positively to the environment and promote sustainability.
                Our commitment goes beyond aesthetics; we aim to inspire confidence through our meticulously crafted products. We foster a community where men feel empowered to express themselves through fashion, cultivating connections that celebrate individuality and creativity.
                At the core of our philosophy are the values of integrity, innovation, and inclusivity. We believe that fashion is a powerful form of self-expression, capable of inspiring change and instilling confidence. Through our collections, we invite men to embark on a journey of personal style that is authentic, transformative, and reflective of their true selves.
            </p>
        </div>
    </section>

<section id="our-values">
    <div class="section-container" style="max-width: 1050px; margin: 0 auto; text-align: justify; padding: 30px; background-color: #ffffff; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #8B0000; font-size: 2em; margin-bottom: 20px; text-align: left; font-family: 'Arial', sans-serif; line-height: 2.0;">Our Values</h2>
        <p style="font-size: 1em; color: #333; line-height: 2.0; margin-bottom: 20px; font-family: 'Arial', sans-serif;">
            At Hound Jewelry, our values are the foundation of our business and guide us in every decision we make. We believe that a strong set of core values is crucial not only for our internal culture but also for our external relationships with customers and partners. By embedding these principles into our daily operations, we create a cohesive environment that fosters trust and collaboration.
        </p>
        <hr style="border: 2px solid #8B0000; margin: 20px 0;">
        <ul style="list-style: none; padding: 0; line-height: 2.0; margin-bottom: 20px;">
            <li style="margin-bottom: 30px; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                <h4 style="color: #8B0000; font-size: 1.5em; font-family: 'Arial', sans-serif; line-height: 2.0;">
                    <strong><i class="fas fa-check-circle" style="color: #8B0000; margin-right: 8px;"></i>Quality</strong>
                </h4>
                <p style="color: #555; font-size: 0.9em; line-height: 2.0;">
                    At Hound Jewelry, we prioritize craftsmanship and materials, ensuring that every piece is made to last. Our commitment to quality is reflected in our meticulous design process and the care we take in selecting the finest materials. We continuously seek feedback to enhance our products and maintain the highest standards in every detail. Each piece is a testament to our dedication, embodying both elegance and durability.
                </p>
            </li>
            <li style="margin-bottom: 30px; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                <h4 style="color: #8B0000; font-size: 1.5em; font-family: 'Arial', sans-serif; line-height: 2.0;">
                    <strong><i class="fas fa-gavel" style="color: #8B0000; margin-right: 8px;"></i>Integrity</strong>
                </h4>
                <p style="color: #555; font-size: 0.9em; line-height: 2.0;">
                    We conduct our business ethically, ensuring transparency and fairness in all our dealings. Upholding our integrity is paramount; we believe in doing the right thing, even when no one is watching. This commitment fosters trust in every interaction and strengthens our relationships with customers, suppliers, and the community.
                </p>
            </li>
            <li style="margin-bottom: 30px; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                <h4 style="color: #8B0000; font-size: 1.5em; font-family: 'Arial', sans-serif; line-height: 2.0;">
                    <strong><i class="fas fa-paint-brush" style="color: #8B0000; margin-right: 8px;"></i>Creativity</strong>
                </h4>
                <p style="color: #555; font-size: 0.9em; line-height: 2.0;">
                    We foster an environment that encourages innovative designs reflecting the personality and preferences of our customers. Our team explores new ideas and techniques, ensuring our collections resonate with the latest trends while maintaining our unique aesthetic.
                </p>
            </li>
            <li style="margin-bottom: 30px; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                <h4 style="color: #8B0000; font-size: 1.5em; font-family: 'Arial', sans-serif; line-height: 2.0;">
                    <strong><i class="fas fa-users" style="color: #8B0000; margin-right: 8px;"></i>Community</strong>
                </h4>
                <p style="color: #555; font-size: 0.9em; line-height: 2.0;">
                    We are committed to giving back to our community and supporting local artisans. By investing in local talent, we help preserve traditional craftsmanship and promote sustainable practices. Building strong relationships enhances the quality of life for many.
                </p>
            </li>
            <li style="margin-bottom: 30px;">
                <h4 style="color: #8B0000; font-size: 1.5em; font-family: 'Arial', sans-serif; line-height: 2.0;">
                    <strong><i class="fas fa-leaf" style="color: #8B0000; margin-right: 8px;"></i>Sustainability</strong>
                </h4>
                <p style="color: #555; font-size: 0.9em; line-height: 2.0;">
                    Our commitment to sustainability drives us to minimize our environmental impact through responsible sourcing and production practices. We focus on using eco-friendly materials, aiming to inspire our customers to make environmentally conscious choices.
                </p>
            </li>
        </ul>
        <p style="font-size: 1em; color: #333; line-height: 2.0; margin-bottom: 20px; font-family: 'Arial', sans-serif;">
            We strive to create a positive impact not only through our products but also in our relationships. By adhering to these values, we aim to foster a culture that drives our business forward while encouraging personal and professional growth among our team members.
        </p>
        <p style="font-size: 1em; color: #333; line-height: 2.0; margin-bottom: 20px; font-family: 'Arial', sans-serif;">
            Our commitment to these principles ensures that we remain focused on our mission while building a brand that our customers can trust and feel proud to be a part of. Together, we are crafting a legacy of quality, integrity, and community spirit.
        </p>
        <div style="text-align: center; margin-top: 30px;">
            <img src="assets/images/values.png" alt="Our Values" class="section-image" style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        </div>
    </div>
</section>

<section id="our-culture">
    <div class="section-container" style="max-width: 1050px; margin: 0 auto; text-align: justify; background: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 30px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: left; color: #8B0000; font-size: 2em; line-height: 2.0;">Our Culture</h2>
        <p style="font-size: 1em; color: #555; text-indent: 1.5em; line-height: 2.0;">
            At <span style="font-weight: bold; color: darkred;">Hound Jewelry</span>, we cultivate a culture centered on creativity, respect, and collaboration. Our passionate team believes in nurturing talent and encouraging innovative ideas. We strive to create an environment where every member feels valued, recognizing that our success hinges on the diverse perspectives and experiences each team member brings. Open communication and mutual respect are vital to our culture, strengthening our bonds and enhancing collaboration.
        </p>

        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; margin-top: 20px;">
            <div style="flex: 1; display: flex; flex-direction: column; gap: 20px;">
                <!-- Card 1 -->
                <div style="background: #fff; padding: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <img src="assets/images/diver.png" alt="Diversity" style="width: 950; height: 400;display: block; margin: 0 auto;">
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Diversity & Inclusivity</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">We embrace diverse backgrounds, enhancing our creativity and innovation.</p>
                </div>
                <!-- Card 2 -->
                <div style="background: #fff; padding: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <img src="assets/images/professional.png" alt="Professional Development" style="width: 950; height: 400; display: block; margin: 0 auto;">
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Professional Development</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">We provide training and mentorship to foster continuous growth.</p>
                </div>
                <!-- Card 3 -->
                <div style="background: #fff; padding: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <img src="assets/images/happy.png" alt="Happy Team" style="width: 950; height: 400; display: block; margin: 0 auto;">
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Happy Team, Happy Customers</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">A positive work environment leads to exceptional client experiences.</p>
                </div>
                <!-- Card 4 -->
                <div style="background: #fff; padding: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <img src="assets/images/engagement.png" alt="Community Engagement" style="width: 950; height: 400; display: block; margin: 0 auto;">
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Community Engagement</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">We actively support local artisans and charitable initiatives.</p>
                </div>
                <!-- Card 5 -->
                <div style="background: #fff; padding: 15px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <img src="assets/images/sus.png" alt="Sustainability" style="width: 950; height: 400; display: block; margin: 0 auto;">
                    <h3 style="color: darkred; text-align: center; font-size: 1.5em; line-height: 2.0;">Sustainability</h3>
                    <p style="color: #555; text-align: center; font-size: 0.9em; line-height: 2.0;">We commit to ethical sourcing and eco-friendly practices.</p>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <h3 style="color: darkred; font-size: 1.5em; line-height: 2.0;">Core Values</h3>
            <p style="font-size: 1em; color: #333; text-indent: 1.5em; line-height: 2.0;">
                Our culture is built on teamwork, celebrating individual achievements while pursuing collective excellence. We actively engage in community initiatives, supporting local artisans and charities. Sustainability is a cornerstone of our values; we commit to ethical sourcing and eco-friendly practices, continuously seeking to reduce our carbon footprint. Our open-door policy fosters transparency and trust, encouraging feedback and collaboration. We believe that diversity is our strength, as the unique perspectives of our team members drive innovation and creativity. Through regular training sessions and workshops, we ensure that everyone has the opportunity to grow and contribute to our shared goals. This commitment to inclusion creates a vibrant workplace where ideas can flourish and everyone feels empowered to express themselves.
            </p>
        
            <h3 style="color: darkred; font-size: 1.5em; line-height: 2.0;">Commitment to Growth</h3>
            <p style="font-size: 1em; color: #333; text-indent: 1.5em; line-height: 2.0;">
                We believe in the power of feedback and continuous improvement. Our team regularly engages in constructive discussions that drive innovation and enhance our processes. We prioritize work-life balance, understanding that a healthy work environment leads to greater productivity. Our commitment to mental health and wellness is reflected in various initiatives, including wellness programs and flexible work arrangements. We provide ongoing professional development opportunities, from skill-building workshops to leadership training, ensuring that our employees are equipped with the tools they need to succeed. By fostering a culture of learning, we create pathways for career advancement and personal fulfillment. Our mentorship programs connect experienced team members with those seeking guidance, promoting knowledge sharing and collaboration across all levels of the organization.
            </p>
        
            <h3 style="color: darkred; font-size: 1.5em; line-height: 2.0;">Social Responsibility</h3>
            <p style="font-size: 1em; color: #333; text-indent: 1.5em; line-height: 2.0;">
                Our commitment to social responsibility extends beyond our immediate community. We engage in partnerships with various non-profit organizations, contributing our time and resources to causes that align with our values. This involvement enriches our team’s experience and reinforces our commitment to making a positive impact in the world. We are proud to cultivate a workplace where every member understands the importance of giving back, ensuring that our business practices reflect our ethos of compassion and community engagement. Each year, we organize volunteer days where our team can participate in community service projects, allowing us to support local needs directly. Additionally, our corporate giving program matches employee donations to non-profits, amplifying our impact. We also advocate for environmental stewardship through initiatives aimed at reducing waste and promoting sustainable practices not only within our operations but also within our supply chain. By fostering an environment of responsibility and awareness, we strive to inspire our employees to make a difference both personally and professionally.
            </p>
        </div>

        <!-- Moved the image here -->
        <div style="margin-top: 30px; text-align: center;">
            <img src="assets/images/culture.png" alt="Our Culture" style="max-width: 100%; height: auto; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        </div>
    </div>
</section>
<section id="meet-our-team">
    <h2>Meet Our Team</h2>
    <div class="team-container"style="max-width: 1450px; margin: 0 auto; text-align: justify;">
        <div class="team-member" id="member1">
            <img src="assets/images/prof2.png" alt="Alice Johnson">
            <h3>Anton Maristela</h3>
            <p>Marketing Director</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="team-member" id="member2">
            <img src="assets/images/prof5.png" alt="Bob Smith">
            <h3>Fritz Dela Cruz</h3>
            <p>Inventory Manager</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="team-member" id="member3">
            <img src="assets/images/prof9.png" alt="Charlie Kim">
            <h3>Erick Marquez</h3>
            <p>Chief Executive Officer</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="team-member" id="member4">
            <img src="assets/images/prof3.png" alt="Roxie Swanson">
            <h3>Charles Mesa</h3>
            <p>Operations Manager</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="team-member" id="member5">
            <img src="assets/images/prof4.png" alt="John Doe">
            <h3>Van Daniel Santos</h3>
            <p>Sales Executive</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</section>
</main>
</div>
@include('layouts.inc.frontfooter')
<script>
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.classList.remove('active'); // Remove active class from all sections
    });

    // Show the selected section
    const activeSection = document.getElementById(sectionId);
    activeSection.classList.add('active'); // Add active class to the current section

    // Update the sidebar links
    const links = document.querySelectorAll('.sidebar a');
    links.forEach(link => {
        link.classList.remove('active'); // Remove active class from all links
    });

    // Add active class to the clicked link
    const currentLink = Array.from(links).find(link => 
        link.getAttribute('onclick').includes(sectionId)
    );

    if (currentLink) {
        currentLink.classList.add('active'); // Add active class to the current link
    }

    // Store the selected section in local storage
    localStorage.setItem('activeSection', sectionId);

    // Trigger animation for team members if section is "meet-our-team"
    if (sectionId === 'meet-our-team') {
        showMembers();
    }
}

function showMembers() {
    const members = document.querySelectorAll('.team-member');
    members.forEach((member, index) => {
        setTimeout(() => {
            member.classList.add('show'); // Show each member with a delay
        }, index * 500); // 500ms delay between each member
    });
}

// Automatically show the last selected section on page load
document.addEventListener("DOMContentLoaded", () => {
    const activeSection = localStorage.getItem('activeSection') || 'our-mission'; // Default to the first section if none is stored
    showSection(activeSection); // Show the stored section
});
</script>
@endsection