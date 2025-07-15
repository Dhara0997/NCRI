<?php get_header(); ?>
<main id="content">
    <div class="container">
        
        <header class="header alignfull">
            <div class="container">
               <h1 class="entry-title"><?php _e( 'Page Not Found', 'ncri' ); ?></h1>
            </div>
        </header>
        
        <div class="row">
            
            <div class="col-lg-8">
                <article id="post-0" class="post not-found">
                   
                    <section class="entry-content">
                        <div style="height: 60px;"></div>
                        <h2>Sorry, we can't connect the dots</h2>
                        <p>
                            <?php _e( 'Nothing found for the requested page. Try a search instead?', 'ncri' ); ?>
                        </p>
                        <?php get_search_form(); ?>
                        <div style="height: 160px;"></div>
                    </section>
                </article>
            </div>
            
            <div class="col-md-4">
                <?php //get_sidebar(); ?>
            </div>
            
        </div>
    </div>
</main>

<?php get_footer(); ?>