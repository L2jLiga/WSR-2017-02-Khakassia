$(document).ready(function(){

/**
 * Переходы
 */
$("[data-target]").on("click", function (){
	$("#" + $(this).attr("data-target")).fadeOut(300);
	$("#" + $(this).attr("data-target") + "+ *").fadeIn(300);
});

$("[data-prev]").on("click", function(){
	$(this).parent().find("div").html("<b>Описание: </b>")
	$("#" + $(this).attr("data-prev")).fadeIn(300);
	$("#" + $(this).attr("data-prev") + "+ *").fadeOut(300);

})

$("#section5 [data-target]").on("click", function (){
	var img = $(this).parent().find("img").attr("src"),
		header = $(this).parent().find("h3").html(),
		desc = $(this).parent().find("p").html();

	$("#section6 img").attr("src", img);
	$("#section6 h2").html(header);
	$("#section6 div")[0].innerHTML += desc;
});




$("[data-chat]").on("click", function(){
	$(this).css("animation", "2s boxShadow infinite");
	var t = $(this);
	var Cool = setInterval(()=>{
		t.html() === "Ожидание" ?
		t.html("Ожидание.") : t.html() === "Ожидание." ?
		t.html("Ожидание..") : t.html() === "Ожидание.." ?
		t.html("Ожидание...") : t.html("Ожидание");
	}, 500);
	$("#section6 span.helper").show();
	$("[data-prev]").hide();

	setTimeout(()=>{
		clearTimeout(Cool);
		t.hide();

		var button = document.createElement("button");
		button.innerHTML = "Открыть чат";

		$("#section6").append(button);
		$("#section6 span.helper").hide();
		$("#section6 span.helper2").show();

		$(button).on("click", function(){
			$("#section6").hide();
			$("#section6 div").html("<b>Описание: </b>")
			$("#section6 span").hide();
			$("#section7").show();
			t.show();
			$("[data-prev]").show();
			t.html("Оставить заявку")
			t = null;
			$(button).remove();
			try 
			{
				button.remove();
			}
			catch(e)
			{
				try {
					button.remove;
				}
				finally
				{
					$(button).remove;
				}
			}
		})
	}, 3000)
})


$("#section7 [data-submit]").on("click", function (){
	var text = $(this).parent().find("textarea").val();
	$(this).parent().find("textarea").val("");

	$("#section7 > div").append("<div>От <b>Username</b>:<br/>" + text + "</div>")
});



$("[data-restart]").on("click", function(){
	$(this).parent().hide();
	$("#section1").show();
})
});