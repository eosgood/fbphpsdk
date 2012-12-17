var fb_status = {
  update: function(response) {
    var elems = $('.response');
    elems.html('loading...');

    var statusClass = response.status === 'connected' ? 'alert-success' : 'alert-error';
    var statusElem = $('#response-status');

    statusElem.addClass('alert');
    statusElem.addClass(statusClass);

    statusElem.html('Status: ' + response.status);

    if (!response.authResponse) {
      elems.html(response.status);
      return;
    }

    $('#response-raw').html(JSON.stringify(response.authResponse));
    $('#response-uid').html(response.authResponse.userID);
    $('#response-expires').html(response.authResponse.expiresIn + 'ms');
    $('#response-token').html(response.authResponse.accessToken);
  }
}

