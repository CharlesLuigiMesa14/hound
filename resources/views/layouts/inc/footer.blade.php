<footer class="footer" style="background-color: white; color: #343a40; padding: 20px 0;">
    <div class="container-fluid text-center">
        <div class="copyright">
            &copy; <span id="year"></span>, made with <i class="material-icons" style="color: red;">favorite</i> by 
            <strong style="color: darkred;">Hound Developers</strong> 
            for a better web.
        </div>
    </div>
</footer>

<script>
    document.getElementById('year').textContent = new Date().getFullYear();
</script>

<style>
    .footer {
        position: relative;
        bottom: 0;
        width: 100%;
        text-align: center;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
    }
    .footer a {
        text-decoration: none;
        color: #17a2b8;
    }
    .footer a:hover {
        text-decoration: underline;
    }
</style>