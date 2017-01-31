// svg zone, svg list :hover | :click
var svgZone = $("#svg-zone"),
    svgList = $("#svg-list"),
    svg = $("svg"),
    $svgZones = svgZone.find("[id^='zone-']"),
    $svgLists = svgList.find("[id^='list-']"),
    activeZone = function (id) {
        $svgZones.css('fill', '');
        if (id !== undefined) {
            var zone = $('#zone-' + id);
            var hoverColor = $('#nodes_dataHoverColor').val();
            zone.css('fill', '#' + hoverColor);    //
            // zone.toggleClass('is-active');
            $('#list-' + id).toggleClass('active');
            // svgZone.find("[id^='zone-']").not(zone).toggleClass('soft-hide');
        }
    };

$svgZones.hover(function () {
    var id = $(this).attr('id').replace('zone-', '');
    activeZone(id)
}).mouseleave(function () {
    activeZone()
}).click(function () {
    var $list = $('#' + $(this).attr('id').replace('zone', 'list'));
    $svgLists.not($list.toggleClass("info")).removeClass('info');

    $('html, body').stop().animate({scrollTop: $list.offset().top - 100}, 300);
});

$svgLists.hover(function () {
    var id = $(this).attr('id').replace('list-', '');
    activeZone(id)
}).mouseleave(function () {
    activeZone()
});


// color pickers

var $colorFillPickers = $('.jsfill'),
    $colorStrokePickers = $('.jsstroke'),
    $colorFillsPickers = $('#jsfills'),
    $colorStrokesPickers = $('#jsstrokes');

$colorFillPickers.on('change', function (e) {
    updateColors(this, 'fill')
});
$colorStrokePickers.on('change', function (e) {
    updateColors(this, 'stroke')
});


$colorStrokesPickers.on('change', function (e) {
    var value = this.value;
    $colorStrokePickers.each(function () {
        this.jscolor.fromString(value)
        updateColors(this, 'stroke')
    })
});
$colorFillsPickers.on('change', function (e) {
    var value = this.value;
    $colorFillPickers.each(function () {
        this.jscolor.fromString(value)
        updateColors(this, 'fill')
    })

});


function updateColors(self, type) {
    var birdselector = document.querySelector('#' + self.getAttribute('data-id'));
    birdselector.setAttribute(type, '#' + self.value);
}

// viewBox
$viewBoxMinx = $('#nodes_viewBoxMinx'),
    $viewBoxMiny = $('#nodes_viewBoxMiny'),
    $viewBoxWidth = $('#nodes_viewBoxWidth'),
    $viewBoxHeight = $('#nodes_viewBoxHeight');

$("#recommend").html('0 0 ' + svg[0].getBBox().width.toFixed(2) + ' ' + svg[0].getBBox().height.toFixed(2));

$(".viewbox").on('change', function () {
    refrechViewBox();
}).TouchSpin({
    forcestepdivisibility: 'none',
    step: 10,
    decimals: 2,
    min: -1000000000,
    max: 1000000000
});

$('#used-button').on("click", function (e) {
    e.preventDefault();
    $viewBoxMinx.val(0);
    $viewBoxMiny.val(0);
    $viewBoxWidth.val(svg[0].getBBox().width.toFixed(2));
    $viewBoxHeight.val(svg[0].getBBox().height.toFixed(2));
    refrechViewBox();
});
function refrechViewBox() {
    var viewboxvalue =
        $viewBoxMinx.val() + ' ' +
        $viewBoxMiny.val() + ' ' +
        $viewBoxWidth.val() + ' ' +
        $viewBoxHeight.val();
    svg[0].setAttribute('viewBox', viewboxvalue);
}

svgZone.stick_in_parent({
    "offset_top": 115
});

// scroll top
var scroll = $('#back-to-top');

$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        scroll.fadeIn();
    } else {
        scroll.fadeOut();
    }
});
scroll.click(function () {
    $('#back-to-top').tooltip('hide');
    $('body,html').animate({
        scrollTop: 0
    }, 800);
    return false;
});
scroll.tooltip('show');