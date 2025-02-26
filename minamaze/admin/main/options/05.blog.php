<?php
/**
 * Blog functions.
 *
 * @package ThinkUpThemes
 */


/* ----------------------------------------------------------------------------------
	BLOG STYLE
---------------------------------------------------------------------------------- */

function thinkup_input_blogclass($classes){

// Get theme options values.
$thinkup_blog_style        = thinkup_var ( 'thinkup_blog_style' );
$thinkup_blog_style1layout = thinkup_var ( 'thinkup_blog_style1layout' );

	if ( thinkup_check_isblog() ) {
		if ( empty( $thinkup_blog_style ) or $thinkup_blog_style == 'option1' ) {
			if ( $thinkup_blog_style1layout !== 'option2' ) {
				$classes[] = 'blog-style1 blog-style1-layout1';
			} else {
				$classes[] = 'blog-style1 blog-style1-layout2';
			}
		} else {
			$classes[] = 'blog-style2';
		}
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_input_blogclass');


/* ----------------------------------------------------------------------------------
	BLOG STYLE (INCLUDED TO ALLOW ADDITION OF NEW LAYOUTS IN FUTURE UPDATE)
---------------------------------------------------------------------------------- */

function thinkup_input_stylelayout() {

// Get theme options values.
$thinkup_blog_style        = thinkup_var ( 'thinkup_blog_style' );
$thinkup_blog_style2layout = thinkup_var ( 'thinkup_blog_style2layout' );

	if ( $thinkup_blog_style !== 'option2' ) {
		echo ' column-1';
	} else if ( $thinkup_blog_style == 'option2' ) {
		if ( empty($thinkup_blog_style2layout) or $thinkup_blog_style2layout == 'option1' ) {
			echo ' column-1';
		} else if ( $thinkup_blog_style2layout == 'option2' ) {
			echo ' column-2';
		} else if ( $thinkup_blog_style2layout == 'option3' ) {
			echo ' column-3';
		} else if ( $thinkup_blog_style2layout == 'option4' ) {
			echo ' column-4';
		}
	}
}


/* ----------------------------------------------------------------------------------
	BLOG STYLE - CLASSES FOR STYLE 1
---------------------------------------------------------------------------------- */

function thinkup_input_stylelayout_class1() {
global $post;

// Get theme options values.
$thinkup_blog_postswitch   = thinkup_var ( 'thinkup_blog_postswitch' );
$thinkup_blog_style        = thinkup_var ( 'thinkup_blog_style' );
$thinkup_blog_style1layout = thinkup_var ( 'thinkup_blog_style1layout' );

	if ( has_post_thumbnail( $post->ID ) and $thinkup_blog_postswitch !== 'option2' ) {
		if ( $thinkup_blog_style !== 'option2' and $thinkup_blog_style1layout !== 'option2' ) {
			echo ' two_fifth';
		}
	}
}

function thinkup_input_stylelayout_class2() {
global $post;

// Get theme options values.
$thinkup_blog_postswitch   = thinkup_var ( 'thinkup_blog_postswitch' );
$thinkup_blog_style        = thinkup_var ( 'thinkup_blog_style' );
$thinkup_blog_style1layout = thinkup_var ( 'thinkup_blog_style1layout' );

	if ( has_post_thumbnail( $post->ID ) and $thinkup_blog_postswitch !== 'option2' ) {
		if ( $thinkup_blog_style !== 'option2' and $thinkup_blog_style1layout !== 'option2' ) {
			echo ' three_fifth last';
		}
	}
}


/* ----------------------------------------------------------------------------------
	HIDE POST TITLE
---------------------------------------------------------------------------------- */

function thinkup_input_blogtitle() {

	echo	'<h2 class="blog-title">',
			'<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'minamaze' ), the_title_attribute( 'echo=0' ) ) ) . '">' . get_the_title() . '</a>',
			'</h2>';
}


/* ----------------------------------------------------------------------------------
	BLOG CONTENT
---------------------------------------------------------------------------------- */

/* Input post thumbnail / featured media */
if ( !function_exists( 'thinkup_input_blogimage' ) ) {
	function thinkup_input_blogimage() {
	global $post;

	// Get theme options values.
	$thinkup_blog_style     = thinkup_var ( 'thinkup_blog_style' );
	$thinkup_blog_stylegrid = thinkup_var ( 'thinkup_blog_stylegrid' );

		// Assign default variable values
		$size  = NULL;

		// Set image size
		if ( $thinkup_blog_style !== 'option2' ) {
			$size = 'column2-3/5';
		} else if ( $thinkup_blog_style == 'option2' ) {			
			if ( empty($thinkup_blog_stylegrid) or $thinkup_blog_stylegrid == 'option1' ) {
				$size = 'column1-1/3';
			} else if ( $thinkup_blog_stylegrid == 'option2' ) {
				$size = 'column2-1/2';
			} else if ( $thinkup_blog_stylegrid == 'option3' ) {
				$size = 'column3-1/2';
			} else if ( $thinkup_blog_stylegrid == 'option4' ) {
				$size = 'column4-1/2';
			}
		}

		if ( has_post_thumbnail() ) {
			echo '<div class="blog-thumb"><a href="'. esc_url( get_permalink($post->ID) ) . '">' . get_the_post_thumbnail( $post->ID, $size ) . '</a></div>';
		}
	}
}

/* Input post excerpt / content to blog page */
function thinkup_input_blogtext() {
global $post;

// Get theme options values.
$thinkup_blog_postswitch = thinkup_var ( 'thinkup_blog_postswitch' );

	// Output full content - EDD plugin compatibility
	if( function_exists( 'EDD' ) and is_post_type_archive( 'download' ) ) {
		the_content();
		return;
	}

	// Output post content
	if ( is_search() ) {
		the_excerpt();
	} else if ( ! is_search() ) {
		if ( ( empty( $thinkup_blog_postswitch ) or $thinkup_blog_postswitch == 'option1' ) ) {
			if( ! is_numeric( strpos( $post->post_content, '<!--more-->' ) ) ) {
				the_excerpt();
			} else {
				the_content();
				wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'minamaze' ), 'after'  => '</div>', ) );
			}
		} else if ( $thinkup_blog_postswitch == 'option2' ) {
			the_content();
			wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'minamaze' ), 'after'  => '</div>', ) );
		}
	}
}


/* ----------------------------------------------------------------------------------
	BLOG META CONTENT & POST META CONTENT
---------------------------------------------------------------------------------- */

// Input sticky post
function thinkup_input_sticky() {
	printf( '<span class="sticky"><i class="fa fa-thumb-tack"></i><a href="%1$s" title="%2$s">' . esc_html__( 'Sticky', 'minamaze' ) . '</a></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_title() )
	);
}

/* Input blog date*/
function thinkup_input_blogdate() {
	printf( __( '<span class="date"><i class="fa fa-calendar-o"></i><a href="%1$s" title="%2$s"><time datetime="%3$s">%4$s</time></a></span>', 'minamaze' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_title() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}

/* Input blog comments */
function thinkup_input_blogcomment() {

	if ( '0' != get_comments_number() ) {
	echo	'<span class="comment"><i class="fa fa-comments"></i>';
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {;
			comments_popup_link( esc_html__( '0 comments', 'minamaze' ), esc_html__( '1 comment', 'minamaze' ), __( '% comments', 'minamaze' ) );
		};
	echo	'</span>';
	}
}

/* Input blog categories */
function thinkup_input_blogcategory() {
$categories_list = get_the_category_list( __( ', ', 'minamaze' ) );

	if ( $categories_list && thinkup_input_categorizedblog() ) {
		echo	'<span class="category"><i class="fa fa-folder-open"></i>';
		printf( '%1$s', $categories_list );
		echo	'</span>';
	};
}

/* Input blog tags */
function thinkup_input_blogtag() {
$tags_list = get_the_tag_list( '', __( ', ', 'minamaze' ) );

	if ( $tags_list ) {
		echo	'<span class="tags"><i class="fa fa-tags"></i>';
		printf( '%1$s', $tags_list );
		echo	'</span>';
	};
}

/* Input blog author */
function thinkup_input_blogauthor() {
	printf( __( '<span class="author"><i class="fa fa-pencil"></i>By <a href="%1$s" title="%2$s" rel="author">%3$s</a></span>', 'minamaze' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'minamaze' ), get_the_author() ) ),
		get_the_author()
	);
}


//----------------------------------------------------------------------------------
//	CUSTOM READ MORE BUTTON.
//----------------------------------------------------------------------------------

function thinkup_input_readmore() {
	return '<p><a href="'. esc_url( get_permalink( get_the_ID() ) ) . '" class="more-link themebutton">' . esc_html__( 'Read More', 'minamaze') . '</a></p>';
}
add_filter( 'excerpt_more', 'thinkup_input_readmore' );
add_filter( 'the_content_more_link', 'thinkup_input_readmore' );


/* ----------------------------------------------------------------------------------
	INPUT BLOG META CONTENT
---------------------------------------------------------------------------------- */

function thinkup_input_blogmeta() {

// Get theme options values.
$thinkup_blog_date     = thinkup_var ( 'thinkup_blog_date' );
$thinkup_blog_author   = thinkup_var ( 'thinkup_blog_author' );
$thinkup_blog_comment  = thinkup_var ( 'thinkup_blog_comment' );
$thinkup_blog_category = thinkup_var ( 'thinkup_blog_category' );
$thinkup_blog_tag      = thinkup_var ( 'thinkup_blog_tag' );

	if ( $thinkup_blog_date !== '1' or 
		$thinkup_blog_author !== '1' or 
		$thinkup_blog_comment !== '1' or 
		$thinkup_blog_category !== '1' or 
		$thinkup_blog_tag !== '1') {

		echo '<div class="entry-meta">';
			if ( is_sticky() && is_home() && ! is_paged() ) { thinkup_input_sticky(); }

			if ($thinkup_blog_author !== '1')   { thinkup_input_blogauthor();   }
			if ($thinkup_blog_date !== '1')     { thinkup_input_blogdate();     }
			if ($thinkup_blog_comment !== '1')  { thinkup_input_blogcomment();  }	
			if ($thinkup_blog_category !== '1') { thinkup_input_blogcategory(); }
			if ($thinkup_blog_tag !== '1')      { thinkup_input_blogtag();      }
		echo '</div>';
	}
}


/* ----------------------------------------------------------------------------------
	INPUT POST META CONTENT
---------------------------------------------------------------------------------- */
function thinkup_input_postmeta() {

// Get theme options values.
$thinkup_post_date     = thinkup_var ( 'thinkup_post_date' );
$thinkup_post_author   = thinkup_var ( 'thinkup_post_author' );
$thinkup_post_comment  = thinkup_var ( 'thinkup_post_comment' );
$thinkup_post_category = thinkup_var ( 'thinkup_post_category' );
$thinkup_post_tag      = thinkup_var ( 'thinkup_post_tag' );

	if ( $thinkup_post_date !== '1' or 
		$thinkup_post_author !== '1' or 
		$thinkup_post_comment !== '1' or 
		$thinkup_post_category !== '1' or 
		$thinkup_post_tag !== '1') {

		echo '<header class="entry-header entry-meta">';
			if ($thinkup_post_author !== '1')   { thinkup_input_blogauthor();   }
			if ($thinkup_post_date !== '1')     { thinkup_input_blogdate();     }
			if ($thinkup_post_comment !== '1')  { thinkup_input_blogcomment();  }	
			if ($thinkup_post_category !== '1') { thinkup_input_blogcategory(); }
			if ($thinkup_post_tag !== '1')      { thinkup_input_blogtag();      }
		echo '</header><!-- .entry-header -->';
	}
}


/* ----------------------------------------------------------------------------------
	TEMPLATE FOR COMMENTS AND PINGBACKS (PREVIOUSLY IN TEMPLATE-TAGS).
---------------------------------------------------------------------------------- */
function thinkup_input_commenttemplate( $comment, $args, $depth ) {

	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php esc_html_e( 'Pingback:', 'minamaze'); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'minamaze' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">

			<header>
				<?php echo get_avatar( $comment, 60 ); ?>

				<span class="comment-author">
					<?php printf( '%s', sprintf( '%s', get_comment_author_link() ) ); ?>
				</span>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'minamaze'); ?></em>
					<br />
				<?php endif; ?>

				<span class="comment-meta">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php esc_attr( comment_time( 'c' ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( '%1$s', get_comment_date() ); ?>
					</time></a>
					<?php edit_comment_link( esc_html__( 'Edit', 'minamaze' ), ' ' );
					?>
				</span>

				<span class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</span>
			</header><div class="clearboth"></div>

			<footer>
				<div class="comment-content"><?php comment_text(); ?></div>
			</footer>
		</article><!-- #comment-## -->

	<?php
	break;
	endswitch;
}


/* List comments in single page */
function thinkup_input_comments() {
	$args = array( 
		'callback' => 'thinkup_input_commenttemplate', 
	);
	wp_list_comments( $args );
}


?>