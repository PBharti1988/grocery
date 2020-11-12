$.fn.addDownloadBtn = function (
  text,
  className
) {
  var el = $(this);

  if (el.is("img")) {
    var tagLink = "<a>";
    var tagDiv = "<div>";

    var cssDiv = {
      display: "inline-block",
      position: "relative"
    };
    var cssLink = {
      position: "absolute",
      bottom: "-10px",
      right: "10px"
    };

    var elDiv = $(tagDiv).css(cssDiv);

    var elImg = el.clone();
    var elImgSrc = el.attr("src");

    var elLink = $(tagLink)
      .attr("href",  $(this).attr("src"))
      .attr("download", "")
      .text(text)
      .addClass(className)
      .css(cssLink);

    var all = elDiv.append(elImg).append(elLink);

   // $("img").replaceWith(all);
    $(this).replaceWith(all);

    return elLink;
  }
};