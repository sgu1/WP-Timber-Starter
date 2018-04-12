# WP-Timber-Starter
<h3>My repository to get quickly started with the timber plugin</h3>
<p>
This repo uses gulp and npm. Everything is already set up to compile your js and sass. Please take a look over the gulpfile to see what it does.
gitignore is set up to ignore everything except the theme. There are also white lists that you can add.
</p>
<br/>

# Steps to getting set-up with this starter theme

1. Edit the composer package details in _composer. Check name, description, and acf and timber version is correct or not.
2. Install the composer pakage via composer install --no-dev
3. Edit the the npm packge in _gulp_npm. Check name, description, and dependency versions. Optionally you can run npm outdated to see what's outdated and then npm update.
4. Go in to the gulpfile now and change what you need to. If you changed the folder names and structure, you should change it here too.
5. Using a command terminal, cd in to _gulp_npm and type command 'gulp'
6. Great, now you can start coding!

# Additional Checks
1. SCSS files in _resources have random stuff. Modify and delete the files you don't need.
2. In the theme folder under logic. There's a file call acf_displays. I use this to organize my complex logical acf fields, you can remove it if you don't need it.
3. In the theme folder, the page.php is removed. index.php will handle that.

It's pretty flexible, you can remove what you don't need and customize this starter theme, it's a boilerplate and not meant to be a framework.

<p>
<strong>Happy WordPress Theming!</strong>
</p>