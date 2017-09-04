<?php
  function call($controller, $action) {

    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        $controller = new PagesController();
      break;
      case 'vendors':
        require_once('models/vendor.php');
        $controller = new VendorsController();
      break;
        case 'clients':
        require_once('models/client.php');
        $controller = new ClientsController();
      break;
    }

    $controller->{ $action }();
  }

  // we're adding an entry for the new controller and its actions
  $controllers = array('pages'      => ['home', 'error'],
                       'vendors'    => ['index', 'show', 'getDefaultVendor'],
                       'clients'    => ['index', 'show', 'findByEmail', 'add']
                       );

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>