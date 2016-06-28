var args = require('system').args,
    each = require('@pod-point/utils').each,
    page = require('webpage').create();

/**
 * PhantomJS config object is passed to this script using a URL encoded JSON string. This needs to be decoded and parsed
 * into a JavaScript object.
 */
var config  = JSON.parse(decodeURIComponent(args[3]));

/**
 * We then loop through all the object properties and append them to the PhantomJS webpage module. For more information
 * about possible config options, check out the PhantomJS docs:
 *
 * @link http://phantomjs.org/api/webpage/
 */
each(config, function (value, key) {
    page[key] = value;
});

/**
 * We then open up the webpage via the supplied argument and render it to the location specified in the second argument.
 * Once this process is complete we exit PhantomJS.
 */
page.open(args[1], function() {
    page.render(args[2]);
    phantom.exit();
});
