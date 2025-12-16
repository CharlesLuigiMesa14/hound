<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('assets/images/slider1.png')}}" class="d-block w-100" alt="Hound Jewelry Shop - Collection 1">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/images/slider2.png')}}" class="d-block w-100" alt="Hound Jewelry Shop - Collection 2">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="carousel-header">Stunning Earrings</h5>
        <p>Explore our stunning earrings, perfect for special occasions or everyday wear.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/images/slider3.png')}}" class="d-block w-100" alt="Hound Jewelry Shop - Collection 3">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="carousel-header">Beautiful Bracelets</h5>
        <p>Adorn your wrist with our beautiful bracelets, designed to make a statement.</p>
      </div>
    </div>
  </div>
  <!-- Removed the navigation arrows -->
</div>

<style>
  .carousel-header {
    font-weight: bold;
    font-size: 2rem; /* Adjust the size as needed */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Optional: adds a shadow for better visibility */
  }

  @media (max-width: 768px) {
    .carousel-header {
      font-size: 1.5rem; /* Responsive size for smaller screens */
    }
  }

  .carousel-item {
    transition: transform 1s ease, opacity 1s ease; /* Smooth transition for slides */
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<script>
  // Ensure that the carousel auto-slides smoothly
  var myCarousel = document.getElementById('carouselExampleCaptions');
  var carousel = new bootstrap.Carousel(myCarousel, {
    interval: 5000, // Time in milliseconds for auto-slide
    pause: 'hover' // Pause on hover
  });
</script>