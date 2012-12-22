jQuery(document).ready(function() {
    jQuery("div#list_categories table tr").each(function(index) {
        var row = this;
        
        // Editing a category.
        jQuery(row).find("button.edit").click(function() {
            var category_id = jQuery(row).find("td.category_id").text();
            var category_name = jQuery(row).find("td.category_name").text();
            var url_name = jQuery(row).find("td.url_name").text();
            var active = jQuery(row).find("td.active").text();
            var priority = jQuery(row).find("td.priority").text();
            jQuery("#edit_category input#category_id").val(category_id);
            jQuery("#edit_category input#category_name").val(category_name);
            jQuery("#edit_category input#url_name").val(url_name);
            if (active == 1) {
                jQuery("#edit_category input#active").attr("checked", "checked");
            }
            else if (active == 0) {
                jQuery("#edit_category input#active").removeAttr("checked");
            }
            jQuery("#edit_category input#priority").val(priority);
        });
        
        // Deleting a category.
        jQuery(this).find("button.delete").click(function() {
            var category_id = jQuery(row).find("td.category_id").text();
            var category_name = jQuery(row).find("td.category_name").text();
            jQuery("#delete_category input#category_id").val(category_id);
            jQuery("#delete_category span#category_delete").text(category_name);
        });
    });
});