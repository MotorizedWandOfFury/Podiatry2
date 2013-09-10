/** 
* Determines if an objects value is empty.
* @param obj The object in which we are testing.
* @return Returns a boolean.
*/
function empty(obj)
{
    switch(obj)
    {
        case "":
        case 0:
        case "0":
        case undefined:
            return true;
        default:
            return false;
    }
}

/**
* Loads a page into a page in which the user is viewing.
* @param url The url to the page.
* @param fade "True" for having a fade effect; "False" for not having a fade effect.
* @param page The page in which we want to load data into.
*/
function doLoad(url, fade, page)
{
    // Hide the survey
    $(page).hide();
    // Load the survey.
    $(page).load(url);
    // Display the survey.
    if (fade == true)
    {
        // Fade in
        $(page).fadeIn(500);
    }
    else
    {
        // Just display the page.
        $(page).show();
    }
}

/**
 * This function is specifically created for doctors. It updates the links on the left panel after
 * having selected a patient from the drop-down box.
 * @param pid Patient id.
 */
function doDoctorLinks(pid)
{
    // If the patient id does not exist...
    if (empty(pid) == true)
    {
        // Destroy all links.
        $("#l1").html("<span style='color: grey; font-weight: bold;'>Pre-Op Eval</span>");
        $("#l2").html("<span style='color: grey; font-weight: bold;'>Surgical Data</span>");
        $("#l3").html("<span style='color: grey; font-weight: bold;'>X-Ray Evaluation</span>");
        $("#l4").html("<span style='color: grey; font-weight: bold;'>Post Evaluation</span>");
        $("#l6").html("<span style='color: grey; font-weight: bold;'>Health Questionnaires</span>");
        $("#l5").html("<span style='color: grey; font-weight: bold;'>Edit Patient</span>");
    }
    else
    {
        // Update all links to fit the patient id.
        $("#l1").html("<a onclick='doLoad(\"eval.php?id=" + pid + "\", false, \"#page\")'>Pre-Op Eval</a>");
        $("#l2").html("<a onclick='doLoad(\"surgical.php?id=" + pid + "\", false, \"#page\")' >Surgical Data</a>");
        $("#l3").html("<a onclick='doLoad(\"xray.php?id=" + pid + "\", false, \"#page\")' >X-Ray Evaluation</a>");
        $("#l4").html("<a onclick='doLoad(\"posteval.php?id=" + pid + "\", false, \"#page\")' >Post Evaluation</a>");
        $("#l6").html("<a onclick='doLoad(\"hquest.php?id=" + pid + "\", false, \"#page\")' >Health Questionnaires</a>");
        $("#l5").html("<a onclick='doLoad(\"edit_patient.php?id=" + pid + "\", false, \"#page\")' >Edit Patient</a>");
    }
}

function EmptyLinks()
{
        // Destroy all links.
        $("#l1").html("<span style='color: grey; font-weight: bold;'>Pre-Op Eval</span>");
        $("#l2").html("<span style='color: grey; font-weight: bold;'>Surgical Data</span>");
        $("#l3").html("<span style='color: grey; font-weight: bold;'>X-Ray Evaluation</span>");
        $("#l4").html("<span style='color: grey; font-weight: bold;'>Post Evaluation</span>");
        $("#l5").html("<span style='color: grey; font-weight: bold;'>Edit Patient</span>");
        $("#l6").html("<span style='color: grey; font-weight: bold;'>Health Questionnaires</span>");
    
}

/**
* This function is used for the clock. It updates the time.
*/
$("#timer").ready(function() {
    setInterval(function() {
        $('#timer').load('clock.php');
    }, 1000 );
});

/**
* This function is used for hovering over anchor tags.
*/
$(document).ready(function() {
    // Hover over <a>
    $("a").mouseover(function() {
        // Remove the tooltip.
        $("#tooltip").remove();
        // Get the attribute of <a>
        var s = $(this).attr("alt");
        // Create a tooltip.
        if (empty(s) != true)
        {
            // Add the <div> to <a>.
            $(this).append("<div style='color: #000000; -moz-border-radius: 15px; border-radius: 15px;' id='tooltip'>" + s + "</div>");
            // Hide the <div> for now.
            $("#tooltip").hide();
        }
    });
    // If moving over <a>
    $("a").mousemove(function(e) {
        // X-Coordinate
        var x = e.pageX - 5;
        // Y-Coordinate
        var y = e.pageY + 20;
        // Width
        var w = $("#tooltip").outerWidth(true);
        // Height
        var h = $("#tooltip").outerHeight(true);
        // Change x value.
        if (x + w > $(window).scrollLeft() + $(window).width()) {
            x = e.pageX - w;
        }
        // Change y value.
        if ($(window).height() + $(window).scrollTop() < y + h) {
            y = e.pageY - h;
        }
        // Update the coordinates based on x, y. Fade it in.
        $("#tooltip").css("left", x).css("top", y).fadeIn(400);
    });
    // If left <a>
    $("a").mouseout(function() {
        // Remove the tooltip.
        $("#tooltip").remove();
    });
});