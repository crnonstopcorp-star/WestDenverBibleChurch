<?php 
# =============================================================================== #
#           IMP NOTES : Please enter SEO values inside double quotes              #  
# =============================================================================== #
switch ($page_slug) {
    case "index":
        $webpage_title              = "Home Page";
        $webpage_description        = "Home page description";
        $webpage_keywords           = "Home page keywords";
        $webpage_schema             = "";
        break;

    case "about":
        $webpage_title              = "About Page";
        $webpage_description        = "About Page description";
        $webpage_keywords           = "About Page keywords";
        $webpage_schema             = "";
        break;

    case "contact":
        $webpage_title              = "Contact Page";
        $webpage_description        = "Contact Page description";
        $webpage_keywords           = "Contact Page keywords";
        $webpage_schema             = "";
        break;

    case "services":
        $webpage_title              = "Services Page";
        $webpage_description        = "Services Page description";
        $webpage_keywords           = "Services Page keywords";
        $webpage_schema             = "";
        break;

    default:
        $webpage_title              = "";
        $webpage_description        = "";
        $webpage_keywords           = "";
        $webpage_schema             = "";
}
# =============================================================================== #
#           IMP NOTES : DO NOT CHANGE ANYTHING IN BELOW LINES                     #  
# =============================================================================== #
?>
    <title>PHP-Repo :: <?php echo $webpage_title; ?></title>
    <meta name="description" content="<?php echo $webpage_description; ?>">
    <meta name="keywords" content="<?php echo $webpage_keywords; ?>">
    <link rel="canonical" href="<?php echo $page_url;?>" />
    <?php 
        if( isset($webpage_schema) && $webpage_schema !="") 
            echo $webpage_schema;
    ?>