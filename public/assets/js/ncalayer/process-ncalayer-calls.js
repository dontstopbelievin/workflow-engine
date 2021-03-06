function getActiveTokensCall() {
    blockScreen();
	getActiveTokens("getActiveTokensBack");
}

function getActiveTokensBack(result) {
    unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var listOfTokens = result['responseObject'];
        $('#storageSelect').empty();
        $('#storageSelect').append('<option value="PKCS12">PKCS12</option>');
        for (var i = 0; i < listOfTokens.length; i++) {
            $('#storageSelect').append('<option value="' + listOfTokens[i] + '">' + listOfTokens[i] + '</option>');
        }
    }
}

function getKeyInfoCall() {
    alert('sula');
    blockScreen();
    var selectedStorage = $('#storageSelect').val();
    getKeyInfo(selectedStorage, "getKeyInfoBack");
    console.log('end1')
}

function getKeyInfoBack(result) {
    unblockScreen();
    console.log('start2')
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        console.log('start1')
        var res = result['responseObject'];
        console.log(result)

        var alias = res['alias'];
        $("#alias").val(alias);

        var keyId = res['keyId'];
        $("#keyId").val(keyId);

        var algorithm = res['algorithm'];
        $("#algorithm").val(algorithm);

        var subjectCn = res['subjectCn'];
        $("#subjectCn").val(subjectCn);

        var subjectDn = res['subjectDn'];
        $("#subjectDn").val(subjectDn);

        var issuerCn = res['issuerCn'];
        $("#issuerCn").val(issuerCn);

        var issuerDn = res['issuerDn'];
        $("#issuerDn").val(issuerDn);

        var serialNumber = res['serialNumber'];
        $("#serialNumber").val(serialNumber);

        var dateString = res['certNotAfter'];
        var date = new Date(Number(dateString));
        $("#notafter").val(date.toLocaleString());

        dateString = res['certNotBefore'];
        date = new Date(Number(dateString));
        $("#notbefore").val(date.toLocaleString());

        var authorityKeyIdentifier = res['authorityKeyIdentifier'];
        $("#authorityKeyIdentifier").val(authorityKeyIdentifier);

        var pem = res['pem'];
        $("#pem").val(pem);
    }
}

function signXmlCall() {
    console.log('start signing')
    var xmlToSign = $("#xmlToSign").val();
    var selectedStorage = $('#storageSelect').val();
	blockScreen();
    signXml(selectedStorage, "SIGNATURE", xmlToSign, "signXmlBack");
}

function signXmlBack(result) {
    unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        var processId = $('#processId').val();
        var application_id = $('#application_id').val();
        var urlToSend = $('#urlToSend').val();

        var determineApproveOrReject = urlToSend.split("/")[1];
        // form the formData
        let formData = new FormData();
        let comments = $('#comments').val();
        let inputs = $('#templateFieldsId :input');
        var rejectReason = $('#rejectReason').val();
        var motiv_otkaz = $('#motiv_otkaz').val();
        var roleToSelect = $("#roleToSelect").val();
        if(roleToSelect && roleToSelect != '-1'){
            formData.append('roleToSelect', roleToSelect);
        }

        if(determineApproveOrReject == 'reject'){
            formData.append('rejectReason',rejectReason);
            formData.append('motiv_otkaz',motiv_otkaz);
            console.log("reject");
            console.log(rejectReason);
            console.log(motiv_otkaz);
        }else if(determineApproveOrReject == 'approve'){
            formData.append('comments', comments);
            inputs.each(function() {
                if ('files' in $(this)[0] && $(this)[0].files != null) {
                    var file = $('input[type=file]')[0].files[0];
                    if(file!==undefined) {
                        formData.append(this.name, file);
                    }
                } else {
                 formData.append(this.name, $(this).val());
                }
            });
            console.log("approve");
        }else if(determineApproveOrReject == 'toCitizen'){
            formData.append('answer', $('#answer').val());
            formData.append('comments', $('#lastComments').val());
        }

        formData.append('process_id', processId);
        formData.append('application_id', application_id);
        formData.append('_token', $('input[name=_token]').val());
        // end of forming the formData

        // create document
        $.ajax({
            url        : '/docs/xmlVerification',
            method     : 'post',
            data       : { "_token" : $('meta[name="csrf-token"]').attr('content'), signedXml: res, processId: processId, applicationId: application_id},
            success: function(response){
                alert('???????????????? ????????????????!');
                // send to corresponding function of ApplicationController
                var xhr = new XMLHttpRequest();
                xhr.open("post", "/" + urlToSend, true);
                xhr.setRequestHeader("Authorization", "Bearer " + $('input[name=_token]').val() );
                xhr.onload = function () {
                    if(xhr.status == 200){
                        $('#error_box').hide('400');
                        location.reload();
                    }else{
                      console.log(xhr);
                      var errors = JSON.parse(xhr.responseText);
                      var errorString = '';
                      $.each(errors.error, function( key, value) {
                          errorString += '<li>' + value + '</li>';
                      });
                      document.getElementById("error_box").innerHTML = errorString;
                      $('#error_box').show('400');
                    }
                }.bind(this)
                xhr.send(formData);
            }
        });
     }
}

function signXmlsCall() {
    var xmlToSign1 = $("#xmlToSign1").val();
	var xmlToSign2 = $("#xmlToSign2").val();
	var xmlsToSign = new Array(xmlToSign1, xmlToSign2);
	var selectedStorage = $('#storageSelect').val();
	blockScreen();
	signXmls(selectedStorage, "SIGNATURE", xmlsToSign, "signXmlsBack");
}

function signXmlsBack(result) {
	unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#signedXml1").val(res[0]);
		$("#signedXml2").val(res[1]);
    }
}

function createCAdESFromFileCall() {
    var selectedStorage = $('#storageSelect').val();
    var flag = $("#flag").is(':checked');
    var filePath = $("#filePath").val();
    if (filePath !== null && filePath !== "") {
		blockScreen();
        createCAdESFromFile(selectedStorage, "SIGNATURE", filePath, flag, "createCAdESFromFileBack");
    } else {
        alert("???? ???????????? ???????? ?????? ??????????????!");
    }
}

function createCAdESFromFileBack(result) {
	unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#createdCMS").val(res);
    }
}

function createCAdESFromBase64Call() {
    var selectedStorage = $('#storageSelect').val();
    var flag = $("#flagForBase64").is(':checked');
    var base64ToSign = $("#base64ToSign").val();
    if (base64ToSign !== null && base64ToSign !== "") {
		$.blockUI();
        createCAdESFromBase64(selectedStorage, "SIGNATURE", base64ToSign, flag, "createCAdESFromBase64Back");
    } else {
        alert("?????? ???????????? ?????? ??????????????!");
    }
}

function createCAdESFromBase64Back(result) {
	$.unblockUI();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#createdCMSforBase64").val(res);
    }
}

function createCAdESFromBase64HashCall() {
    var selectedStorage = $('#storageSelect').val();
    var base64ToSign = $("#base64HashToSign").val();
    if (base64ToSign !== null && base64ToSign !== "") {
		$.blockUI();
        createCAdESFromBase64Hash(selectedStorage, "SIGNATURE", base64ToSign, "createCAdESFromBase64HashBack");
    } else {
        alert("?????? ???????????? ?????? ??????????????!");
    }
}

function createCAdESFromBase64HashBack(result) {
	$.unblockUI();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#createdCMSforBase64Hash").val(res);
    }
}

function applyCAdESTCall() {
    var selectedStorage = $('#storageSelect').val();
    var cmsForTS = $("#CMSForTS").val();
    if (cmsForTS !== null && cmsForTS !== "") {
		$.blockUI();
        applyCAdEST(selectedStorage, "SIGNATURE", cmsForTS, "applyCAdESTBack");
    } else {
        alert("?????? ???????????? ?????? ??????????????!");
    }
}

function applyCAdESTBack(result) {
	$.unblockUI();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#createdCMSWithAppliedTS").val(res);
    }
}

function showFileChooserCall() {
    blockScreen();
    showFileChooser("ALL", "", "showFileChooserBack");
}

function showFileChooserBack(result) {
    unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#filePath").val(res);
    }
}

function showFileChooserForTSCall() {
    blockScreen();
    showFileChooser("ALL", "", "showFileChooserForTSBack");
}

function showFileChooserForTSBack(result) {
    unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#filePathWithTS").val(res);
    }
}

function changeLocaleCall() {
    var selectedLocale = $('#localeSelect').val();
    changeLocale(selectedLocale);
}

function createCMSSignatureFromFileCall() {
    var selectedStorage = $('#storageSelect').val();
    var flag = $("#flagForCMSWithTS").is(':checked');
    var filePath = $("#filePathWithTS").val();
    if (filePath !== null && filePath !== "") {
		blockScreen();
        createCMSSignatureFromFile(selectedStorage, "SIGNATURE", filePath, flag, "createCMSSignatureFromFileBack");
    } else {
        alert("???? ???????????? ???????? ?????? ??????????????!");
    }
}

function createCMSSignatureFromFileBack(result) {
	unblockScreen();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#createdCMSWithTS").val(res);
    }
}

function createCMSSignatureFromBase64Call() {
    var selectedStorage = $('#storageSelect').val();
    var flag = $("#flagForBase64WithTS").is(':checked');
    var base64ToSign = $("#base64ToSignWithTS").val();
    if (base64ToSign !== null && base64ToSign !== "") {
		$.blockUI();
        createCMSSignatureFromBase64(selectedStorage, "SIGNATURE", base64ToSign, flag, "createCMSSignatureFromBase64Back");
    } else {
        alert("?????? ???????????? ?????? ??????????????!");
    }
}

function createCMSSignatureFromBase64Back(result) {
	$.unblockUI();
    if (result['code'] === "500") {
        alert(result['message']);
    } else if (result['code'] === "200") {
        var res = result['responseObject'];
        $("#createdCMSforBase64WithTS").val(res);
    }
}
