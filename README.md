# seasaltpress
A simple starter theme for developers.

**Note:** This theme is for developers and not end users. It still needs lots of styling and some changes here and there based on the theme you plan to make.

## About the theme

The theme is based on underscores which saves hours when making a theme for WordPress. 
I took it and added more stuff to make it even faster to create a website.
Here are the changes I made to underscores to make it seasaltpress.

##Changes

###Added My Sea Salt Grid
My grid has been added and can be used throughout the theme. 
The most helpful classes are .wrap, .content-column, and all other columns (i.e. 'col-1-4', 'col-1-3'...)

Wrap has a max-width and usually contains the columns which are in percentages.
Content-column is a centered column with a max-width defaulted to 600px. It is good for centered content, like an article.
Content-column also allows for .break-out, which gives you back the full width of the page without having to close the column!
This is great to use within the WordPress editor and can help break up your article and look more dynamic.

variables for these classes can be changed under variables in the sass folder.

###Added tinymce Buttons
With a few new buttons you can now add cool stuff to your content in the WordPress Editor.
- **Link button**: simply add a link with class button. so if .button is styled up you and clients can add it easily.
- **Columns**: will prompt you how many you want and create them. If the columns are squished inside the content-column consider using break-out
- **Break-out**: Gives you back the full width of the viewport even when inside a column. The column you break out of must be centered for this to work properly!
- **Wrap**: creates a wrap. REally only useful on pages using blank or full iwdth template as the others already have it installed.
- **Content-Column**: A centered column for content. Already installed on basic posts or regualr pages.

You can add more buttons under inc/tinymce_stuff. You will have to add a button to the js file as well as to the php. And then probably need to use styles to add an icon for the button.

###header-archives
A template that gets called on the blog or post type archive pages.
It allows you to add a header before the list of posts is output.
You can add your own headers here for more post types or change them. Or remove this.... whatever. It gets called at the bottom of header.php

###Content-headers
A new template-part/content-header exists and is called by all single posts and pages.
It creates the header and can be used outside the loop if needed. 
You will have to add to this file for new post types.
(I use it outside the loop when I have a sidebar and still want the heading of the article to be above the article and sidebar. See single-sidebar to understand. You can rename this file to single.php to use sidebars and get rid of the other one.)

###changed posted_on() function to work outside loop.

###WP Customizer
I add some options to the WP Customizer where you can play around to see how it works.
You will probably still need to play around and make changes to get it working the way you want.

####Logo
Found under the identity panel. 
**Using logo() or [logo]**

[logo] is a shortcode and you can use it anywhere! Even in a menu, so you can have a logo inside and centered in a menu.
use echo logo() to output in theme files.

logo() will also output h1 or p tags depending on if its the front page or not.

And if its an svg, which you can upload, it will be output inline so you can style with css!


####Footer widgets
Yuo can add up to 3 footer widgets under the Footer options panel.
Thse will show up in the footer as columns. They use css flex to do their thing. Styles for them can be found in widgets.scss

####Navigation
The panels, site-top-options and site-top layout go together.
You can play around to get something you want. You can even add more stuff into the manual area.
All things inside div#mobilize will be put into the mobile menu area when the mobile query is hit.

You can change the mobile query variable under vairables.
Changes especially to the nav can be made under sass/navigation/seasaltpress_nav.scss
mixins have been created at the top so you can easily style parts without having to scroll down and add it into the code all over.


