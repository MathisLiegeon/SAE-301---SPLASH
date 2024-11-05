<?php
/*
Template Name: Archive Teams Page
*/
get_header();

$args = array (
    'post_type' => 'team',
    'post_per_page' => -1
);

$the_query = new WP_Query($args);
console_log($the_query);

if ($the_query->have_posts()) :
?>

<div class="teams-container">
        <span class="form-element">
            <div class="form-field form-field-search" id="project-search-5">
                <div class="form-select-option">
                    <input type="text" id="project-soValue-5" readonly name="project-5" style="display:none">
                </div>
                <div class="form-search-container-teams">
                    <header id="teams-header" class="teams-header">
                        <h1>Liste des projets</h1>
                        <div class="form-search form-search-teams">
                            <img src="<?php echo get_template_directory_uri();?>/assets/icons/icon_search.svg" alt="Icone représentant une loupe">
                            <input type="text" id="project-search-5" placeholder="Rechercher un projet" name="">
                        </div>
                    </header>
                    <ul class="teams-list form-search-option">
                        <?php
                        while ($the_query->have_posts()) : $the_query->the_post();
                        $members = get_field('members');
                        $captain = get_field('captain');
                        $captain_name = $captain['display_name']

                        ?>
                        <li class="teams-element search-element             ">
                            <a href="<?php echo esc_url(get_permalink());?>" class="teams-link">
                                <span class="teams-img">
                                    <?php the_post_thumbnail('large');?>
                                </span>
                                <h3 class="teams-title">
                                    <?php echo esc_html(get_the_title());?>
                                </h3>
                                <ul class="teams-content">
                                    <?php
                                    foreach ($members as $member) :
                                        $member_name = $member['display_name'];
                                        if ($member_name != $creator_name) :
                                            echo '<li> <span class="teams-members">' . esc_html($member_name) . '</span> </li>';
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                            </a>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </span>
    </header>


<?php
else :
?>
<div class="no-content-error-message">
    <p>
        Aucune équipe ne participe au tournoi pour l'instant
    </p>
</div>

<?php
endif;
get_footer();
