$(document).ready(function() {
    $( "#certificateModal" ).click(function() {
        $("#exampleModal").modal('show');
    });
    $("#cancel-upload").click(function () {
        $("#exampleModal").modal('hide');
    })

    $("#certificate_form_upload").change(function (e){
        if ($('#certificate_form_upload').val()) {
            $('#save-disable').removeAttr("disabled")
            $('.form-group-hide').css("display", 'block')
        }
        const file = e.target.files[0];
        const form_data = new FormData();
        form_data.append('file', file, e.target.files[0].name);
        $.ajax({
            type: "POST",
            url: "/admin/certificates/decode",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            dataType: "json",
            success: function(response) {
                let validFromDate = response.validFrom.date.split('.')[0];
                let validUntilDate = response.validUntil.date.split('.')[0];
                $("#certificate_form_email").html(response.emailAddress)
                $("#certificate_form_certificateFile_hidden").val(response.certificateFile)
                $("#certificate_form_email_hidden").val(response.emailAddress)
                $("#certificate_form_validFrom").html(validFromDate)
                $("#certificate_form_validFrom_hidden").val(validFromDate)
                $("#certificate_form_validUntil").html(validUntilDate)
                $("#certificate_form_validUntil_hidden").val(validUntilDate)
                $("#certificate_form_issuerName").html(response.issuerName)
                $("#certificate_form_name").html(response.name)
                $("#certificate_form_hash").html(response.hash)
                if(response.isActive) {
                    $("#certificate_form_isActive").html(response.isActive).css('color', 'green')
                }else {
                    $("#certificate_form_isActive").html(response.isActive).css('color', 'red')
                }
                $("#certificate_form_issuerCountry").html(response.issuerCountry)
                $("#certificate_form_issuerOrganisation").html(response.issuerOrganisation)
                $("#certificate_form_issuerOrganisationUnit").html(response.issuerOrganisationUnit)
                $("#certificate_form_serialNumber").html(response.serialNumber)
                $("#certificate_form_subjectCountry").html(response.subjectCountry)
                $("#certificate_form_subjectLocation").html(response.subjectLocation)
                $("#certificate_form_subjectName").html(response.subjectName)
                $("#certificate_form_subjectOrganisation").html(response.subjectOrganisation)
            },
            error: function(error) {
                console.log(error);
            }
        });
    })
});
