# seasaltpress
A simple starter theme for developers.
Based on Underscores and Twenty-Seventeen.

The goal of Seasaltpress was to help one create sites with WordPress from scratch without spending too much time setting things up or dealing with the small things.
Check out the site [Seasalt.Press](http://seasalt.press) to see it in action and to learn more!!

WPGulp has been added and modified. You can learn more about it here. [https://github.com/ahmadawais/WPGulp](https://github.com/ahmadawais/WPGulp)

Documentation has been planned. For now here is a quick start guide:

## Download and Install
You can download the theme here or at [Seasalt.Press](http://seasalt.press). The advantage over there is that it will allow you to rename the files and the text domain to the theme name you choose.


### Installing Gulp
The theme now uses Gulp to output the sass files and minify the javascript automatically while you work.
If you have never used Gulp, don't worry, it's easy. First make sure you have node.js installed. [You can install it here](https://nodejs.org/) 

Once installed you need to install Gulp. Use this command:

```npm install --global gulp-cli```

Now _make sure you are in the theme root folder_ where the file package.json resides. Because there is already a package.json file and a Gulp file, all that's left for you to do is install it.
```npm install```
 
This will install npm with all the necessary dependencies. Now Gulp is ready to watch your files and update your javascript.
```gulp```

To Learn More view this great guide by [Ahmad Awais](https://github.com/ahmadawais/WPGulp).
WPGulp is being used although it has been modified. 
- The browser reload has been shut off but you can turn that back on if needed. (If you must know it was really annoying :D )
- Babel has been added so you can write the javascript of tomorrow!
- Javascript files are output minified, but if they end in "custom.js" they will get concatenated to custom.min.js and this file is already enqueued in WordPress for you. 
    + This means you can easily add a new javascript file without having to enqueue it by making sure it ends with "custom.js"  
    
## Starting with the Starter Theme

The html structure of the theme is as follows:<br>
body>#page>.site-top+.site-content+.site-footer


&#35;page holds the whole page in a flex-column and makes sure the footer remains at the bottom (sticky footer)
You should be working in one of the three divs inside it.
 
.site-content holds everything under the top menu down till site-footer. Headers are inside .site-content too. 
In fact they are inside the loop and part of the page or post. This allows for the featured image to be used as a different background header per page and post. Even when there is a sidebar present, the header is in the loop, and the sidebar is put underneath with javascript. With cool-sidebar enabled via the customizer, the sidebar is put off to the side and can be pulled in.
Of course you can go and change anything you want.

### Styles
All your variables are in variable.scss 
Here you can add, remove and make your changes.
Most of the variables are self explanatory but here are some notes.
#### Some important variables

- **$wrap**: The class .wrap has a max width used to center and hold your website. You can set that max-width with this variable. 
- **$gutters**: gutters are padding placed on **both** sides of some elements. This means if it was set to 10px, your gutters would be 20px when two elements with gutters are next to each other.
- **$baseline**: the bottom gutter and margin bottom of many elements.
- **$mobile-width**: When the site should go mobile. Use in some media queries.
- **mobile-nav-width**: When the navigation should go mobile. Sometimes you want this to go mobile faster because you have so many menu items.

### Layout Classes

Some simple layout classes exist and can be used to create columns and structure quite easily without needing a css framework.
The Main Classes to know:
- **.wrap**: can contain and center parts of your site in a max-width of your choosing in variables.scss.
- **.content-width**: a column that is meant for holding main content like articles and posts. It will also be centered unless inside class flex.
- **.gutters**: a class that adds gutters onto the left and right. The gutter size can be set in variables.scss
- **no-gutters**: removes gutters if they are there by default
- **.flex**: flexes any child items, but the items are unflexed on mobile.
- **.stay-on-mobile**: if the flex container has this, the items will remain flexed on mobile.
- **.col**: a basic dynamic sized column with gutters good to use inside .flex. The element will grow and shrink as needed.
- **.col-1-3**: column that is one third the size of its container. Has gutters. There are many of these classes. Try one, it probably exists. Inside .flex it will flex and not float.
- **margin-bottom**: a margin bottom that usually matches the gutters. Can be set with variable $baseline in variables.scss
- **no-margin-bottom**: most columns already have a margin bottom. Remove them with this.
- **negative-gutters**: nesting columns or any div with gutters inside a column or div with gutters will result in the outer one's paddings and the inner one's to double up. Surround the inner columns/divs with this class to remove the issue.

### Customizer
- **Logo**:With the wp customizer you can add an svg logo, which will output inline so you can style with css. Make sure your svg does not have a fill inside.
Your logo will also appear on the login page. It can also be output with [logo]
- **Theme Options**: Here you can decide if you even want to use the customizer, if the site-top should be inside a div.wrap and the positioning of your logo and menu
- **Cool Stuff**: You can choose to use cool-sidebar or not. You can also choose to use cool mobile menu too. check them both out.

### Cool Mixins
- **@include font-size(x)**: where x is a decimal or number. This will give you a font size in rem with px fallback.
- **@include deep-shadow(color, size)**: creates a deep long text shadow that looks cool especially when used in the header on the title. [See here](https://codepen.io/anon/pen/pwMaOw)
- **@include scss-font-lock**: really cool fluid text size based on viewport size. By Alexerlandsson [learn more here](https://github.com/alexerlandsson/scss-font-lock)
- **@include clearfix()**: useful for floats. the site uses flexbox mostly so this is not used as much.

### Default Structure
Seasaltpress comes with some basic default styles that can be changed or easily overridden.
The structure for the headers, and content are found in structure defaults.scss. This file only contains heights and widths and centering... No colors or backgrounds.

- **Post/Page .entry-header**: By default posts and pages have a header with class .entry-header that has a min-height of 40vh. It is flexed and centers the two inner elements .featured-image and .header-content. The structure for these can be seen in structure_defaults.scss
- **.featured-image** has a default height of 300px and holds the post thumbnail and displays above the title in the header. This can be changed to display below or behind the whole header with these classes added to the .entry-header element:
    - .image-below - Puts it below the title in the header.
    - .image-behind - Puts it behind the header and becomes full sized with object-fit: cover.
- **.entry-content** - uses class .content-width and is centered and holds the article. Becomes full width on template blank page.
- **sidebar** - a lot of sidebar work is also in this file and makes sure the sidebar looks right and is structured.

## Icons
Twenty Seventeen had a great function for svg icons, but was only available within the theme itself. Here is how to use it:
 
 ```[your_theme_name]__get_svg( array('icon' => 'name of icon'));```
If you install the plugin [Iodine](https://github.com/saltnpixels/Iodine) you can use them in a shortcode!

```[svg icon="name of icon"]```

You may need to add slight styling per icon to nudge it up or down. See elements.scss for example.

### Rolling your own icons
You can change out the icons for your own! Go to [icomoon.io](https://icomoon.io) and make your own set. Download it as svg and replace the icons folder with your set. Make sure the folder is called icons. It is inside the assets folder.

NOTE: The following icon names must exist, otherwise you need to change them! 
- **sidebar**: Shows up for cool sidebar and mobile sidebar. Localized via functions.php and used on navigation.js
- **menu**: Used in header.php shows up cool menu icon
- **angle-down**: Used in menus with submenus. Localized via functions.php and used on navigation.js

## Custom Fields
You can add basic custom fields via the file seasaltpress_custom_fields.php in folder inc. For anything more complicated please use Pods.

Some fields have been added by default. 
You can remove this folder from functions.php (bottom), although the template parts still look to see if the extra header content exists. However because it doesn't it will ignore and should not get in your way.
