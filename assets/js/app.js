/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

$('#infonote').hide();
/*eslint func-style: ["error", "expression"]*/
$('#Hello').click(function () {
    $('#infonote').slideToggle(1000);
});

$('#msgAdd').hide();
/*eslint func-style: ["error", "expression"]*/
$('#addFavorite').click(function () {
    $('#msgAdd').slideToggle(150);
});
$('#msgDel').hide();
/*eslint func-style: ["error", "expression"]*/
$('#delFavorite').click(function () {
    $('#msgDel').slideToggle(150);
});
