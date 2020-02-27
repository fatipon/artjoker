
var objRegions = [];
var objCities = [];
var objDistricts = [];

function validate(formData) {
	var error = [];
    if(formData.name.length == 0) {
    	error.push("Ім'я не вказано");
	}
    if(formData.email.length == 0) {
    	error.push('Вкажіть свій Email');
	} else {
        if (!validateEmail(formData.email)) {
            error.push('Перевітре введений Email');
        }
	}
    if(formData.selectRegion == -1) {
        error.push('Оберість Область');
    }
    if(formData.selectCity == -1) {
        error.push('Оберіть Місто');
    }
    if(formData.selectDistrict == -1) {
        error.push('Оберіть Район');
    }
    if (error.length > 0) {
        $( "#message-danger" ).empty().show(200);
        $.each(error, function(key, value) {
            $( "#message-danger" ).append( value + '<br>' );
        });
    } else {
        $( "#message-danger" ).empty().hide(200);
	}
	return error;
}

function validateEmail(email) {
    var ve = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return ve.test(email);
}

$.ajax({
    method: "POST",
    url: "/get_region"
})
.done(function( msg ) {
	objRegions = JSON.parse(msg);
    console.log(objRegions.length);
    $.each(objRegions, function(key, value) {
        $('#selectRegion')
            .append($("<option></option>")
                .attr("value",value.ter_id)
                .text(value.ter_name)).trigger("chosen:updated");
    });
});

$(document).ready(function() {
    $(".chosen-select").chosen({width: "50%"});

    $('#selectRegion').change(function (event) {
        $( "#message-success" ).empty().hide(200);
        var idRegion = event.target.value;
		if (idRegion > 0) {

            $.ajax({
                method: "POST",
                url: "/get_city",
                data: { region: idRegion }
            })
			.done(function( msg ) {
				objCities = JSON.parse(msg);
				if (objCities.length > 0) {
                    $('#selectCity').find('option').remove();
                    $('#selectCity')
                        .append($("<option></option>")
                            .attr("value", "-1")
                            .text("Місто .."));
                    $.each(objCities, function(key, value) {
                        $('#selectCity')
                            .append($("<option></option>")
                                .attr("value",value.ter_id)
                                .text(value.ter_name)).trigger("chosen:updated");
                    });
                    $('#selectCity-group').show(300);
                    $('#selectDistrict').find('option').remove();
                    $('#selectDistrict-group').hide(300);
				} else {
                    $('#selectCity-group').hide(300);
                    $('#selectCity').find('option').remove();
				}
			});
		} else {
            $('#selectDistrict-group').hide(300);
            $('#selectDistrict').find('option').remove();
            $('#selectCity-group').hide(300);
            $('#selectCity').find('option').remove();
		}
    });

    
    $('#selectCity').change(function (event) {
        $( "#message-success" ).empty().hide(200);
		var idCity = event.target.value;
		if (idCity > 0) {
            $.ajax({
                method: "POST",
                url: "/get_district",
                data: { city: idCity }
            })
			.done(function( msg ) {
				objDistricts = JSON.parse(msg);
                if (objDistricts.length > 0) {
                    $('#selectDistrict').find('option').remove();
                    $('#selectDistrict')
                        .append($("<option></option>")
                            .attr("value", "-1")
                            .text("Район .."));
                    $.each(objDistricts, function(key, value) {
                        $('#selectDistrict')
                            .append($("<option></option>")
                                .attr("value",value.ter_id)
                                .text(value.ter_name)).trigger("chosen:updated");
                    });
                    $('#selectDistrict-group').show(300);
				} else {
                    $('#selectDistrict-group').hide(300);
                    $('#selectDistrict').find('option').remove();
				}
            });
		} else {
            $('#selectDistrict-group').hide(300);
            $('#selectDistrict').find('option').remove();
        }
    });

    $('#selectDistrict').change(function (event) {
        $("#message-success").empty().hide(200);
    });

    $('#name-group').change(function (event) {
        $("#message-success").empty().hide(200);
    });

    $('#email-group').change(function (event) {
        $("#message-success").empty().hide(200);
    });

    
    $('form').submit(function(event) {
        var formData = {
            'name'           : $('input[name=name]').val(),
            'email'          : $('input[name=email]').val(),
            'selectRegion'   : $('select#selectRegion').val(),
            'selectCity'     : $('select#selectCity').val(),
            'selectDistrict' : $('select#selectDistrict').val()
        };
        var error = validate(formData);
        if (error.length == 0) {
            $.ajax({
                type        : 'POST',
                url         : '/create',
                data        : formData,
                dataType    : 'json',
                encode          : true
            })
			.done(function(data) {
				console.log(data);
				if((data.success) && (data.new_user)){
                    $( "#message-success" ).empty().show(200);
					$( "#message-success" ).append( 'Реєстрація успішна' );
				}
				if((data.success) && (!data.new_user)){
                    $('#modalUser').modal('show');
                    $('.modal-body').empty().append(
                    	'ПІП : ' + data.user[0].name + '<br>' +
						'Email : ' + data.user[0].email + '<br>' +
						'Адреса : ' + data.user[0].location);
				}
			});
		}
        event.preventDefault();
    });
});
