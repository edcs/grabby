var args = require('system').args,
    page = require('webpage').create();

console.log(args);

page.viewportSize = {
    width: args[3],
    height: args[4]
}

page.open(args[1], function() {
    page.render(args[2]);
    phantom.exit();
});
