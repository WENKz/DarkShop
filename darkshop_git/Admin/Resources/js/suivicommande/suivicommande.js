
    $(document).ready(function()
    {
        $(".more").click(function()
        {
            var id = $(this).attr("id");
            $("#a-" + id).slideToggle();
        });
        $(".table-commande:odd").addClass("odd");
//        $(".table-commande:even").addClass('even');
    });