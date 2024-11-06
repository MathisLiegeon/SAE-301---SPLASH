<footer class="footer">
        <a href="<?php echo esc_url(home_url());?>">
                <img src="<?php echo get_template_directory_uri();?>/assets/icons/icon_logo.svg" alt="Icone">
        </a>
        <div class="footer-container">
        <?php
        wp_nav_menu(array('theme_location' => 'footer-menu'));
        ?>
        </div>
        <span class="footer-copyright">Copyright ©Mathis Liegeon – Tous droits réservés.</span>
</footer>
</body>
</html>