function copy_text() {
    document.getElementById("selectcopy").select();
    document.execCommand("copy");
    Swal.fire('', 'Text copied successfully', 'success')
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

function show_details(a){
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    
    $('#detailNetModal').modal("show");
    var agent_id=$(a).attr('id');
    
    var urlNnetwork = baseUrl + "/network/" + agent_id;
    
    var link = document.getElementById("detailNetModalLink");
    link.setAttribute("href", urlNnetwork);
    
    $.ajax({
        url: baseUrl + '/detailNetwork',
        type: 'POST',
        data: {agent_id: agent_id},
        success: function(response){
            $('#agent_detail_show_on_model').html(response);
        }
    })
}

function show_sponsor_details(a){
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    
    $('#detailSponsorModal').modal("show");
    var agent_id=$(a).attr('id');
    
    var urlNnetwork = baseUrl + "/sponsornet/" + agent_id;
    
    var link = document.getElementById("detailSponsorModalLink");
    link.setAttribute("href", urlNnetwork);
    
    $.ajax({
        url: baseUrl + '/detailSponsor',
        type: 'POST',
        data: {agent_id: agent_id},
        success: function(response){
            $('#sponsor_detail_show_on_model').html(response);
        }
    })
}

function show_confirm(a)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#confirmModal').modal("show");
    var agent_id=$(a).attr('id');

    var urlNnetwork = baseUrl + "/confirmPayment/" + agent_id;

    document.getElementById("confirmModalLabel").innerHTML = "Are you ready to confirm this payment?";
    document.getElementById("confirmModalBody").innerHTML = "Select 'OK' below if you are ready to confirm this payment.";

    var link = document.getElementById("confirmPaymentLink");
    link.setAttribute("href", urlNnetwork);
}

function edit_mining(id)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : baseUrl + '/editmining//' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var timestamp = data.datecreate*1000;
            var date = new Date(timestamp);

            var showdate = "Date: "+date.getDate()+
                    "/"+(date.getMonth()+1)+
                    "/"+date.getFullYear();
            
            if(data.type == 1)
            {
                var typeName = "Mining Fil";
            }
            else if(data.type == 2)
            {
                var typeName = "Airdrop MTM";
            }
            else if(data.type == 3)
            {
                var typeName = "Airdrop Zenx";
            }

            $('[name="id"]').val(data.id);
            $('[name="mining-edit"]').val(data.amount);
            $('[name="date"]').val(showdate);
            $('[name="typecoin"]').val(typeName);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Mining Amount'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function save_edit_mining()
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    var url;
    
    url = baseUrl + '/updatemining';

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
                location.reload();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }

            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function pause_mining(a)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#pauseModal').modal("show");
    var agent_id=$(a).attr('id');

    var urlNnetwork = baseUrl + "/pauseMining/" + agent_id;

    document.getElementById("pauseModalLabel").innerHTML = "Are you ready to pause this mining?";
    document.getElementById("pauseModalBody").innerHTML = "Select 'OK' below if you are ready to pause this mining.";

    var link = document.getElementById("pauseLink");
    link.setAttribute("href", urlNnetwork);
}

function continue_mining(a)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#pauseModal').modal("show");
    var agent_id=$(a).attr('id');

    var urlNnetwork = baseUrl + "/continueMining/" + agent_id;

    document.getElementById("pauseModalLabel").innerHTML = "Are you ready to continue this mining?";
    document.getElementById("pauseModalBody").innerHTML = "Select 'OK' below if you are ready to continue this mining.";

    var link = document.getElementById("pauseLink");
    link.setAttribute("href", urlNnetwork);
}

function confirm_basecamp(a)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#basecampModal').modal("show");
    var agent_id=$(a).attr('id');

    var urlNnetwork = baseUrl + "/confirmBasecamp/" + agent_id;

    document.getElementById("basecampModalLabel").innerHTML = "Are you ready to make this user a basecamp?";
    document.getElementById("basecampModalBody").innerHTML = "Select 'OK' below if you are ready to make this user a basecamp";

    var link = document.getElementById("basecampLink");
    link.setAttribute("href", urlNnetwork);
}

function cancel_basecamp(a)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#basecampModal').modal("show");
    var agent_id=$(a).attr('id');

    var urlNnetwork = baseUrl + "/cancelBasecamp/" + agent_id;

    document.getElementById("basecampModalLabel").innerHTML = "Are you sure to cancel this basecamp?";
    document.getElementById("basecampModalBody").innerHTML = "Select 'OK' below if you are sure to cancel this basecamp";

    var link = document.getElementById("basecampLink");
    link.setAttribute("href", urlNnetwork);
}

function show_confirm_deposit(a)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#confirmModal').modal("show");
    var agent_id=$(a).attr('id');

    var urlNnetwork = baseUrl + "/confirmDeposit/" + agent_id;

    document.getElementById("confirmModalLabel").innerHTML = "Are you ready to confirm this deposit?";
    document.getElementById("confirmModalBody").innerHTML = "Select 'OK' below if you are ready to confirm this deposit.";

    var link = document.getElementById("confirmLink");
    link.setAttribute("href", urlNnetwork);
}

function open_basecamp(a)
{
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    $('#basecampModal').modal("show");
    var agent_id=$(a).attr('id');

    var urlNnetwork = baseUrl + "/showBasecamplist/";

    document.getElementById("basecampModalLabel").innerHTML = "Select user";

    $.ajax({
        url: urlNnetwork,
        type: 'POST',
        data: {id: agent_id},
        error: function() {
            document.getElementById("basecampModalBody").innerHTML  = 'Something is wrong';
        },
        success: function(data) {
            document.getElementById("basecampModalBody").innerHTML  = data; 
        }
    });

}

function show_image_deposit(a) {
    // alert('halo dunia');
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/";

    $('#imageModal').modal("show");
    var image = $(a).attr('id');
    document.getElementById("imageModalBody").innerHTML = "<img src='"+baseUrl+"/assets/deposit/"+image+"' width='100%'>";
}
