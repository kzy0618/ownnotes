<?php
 namespace OCA\OwnNotes\Controller;

 use OC\Security\CSP\ContentSecurityPolicy;
 use OCP\IRequest;
 use OCP\AppFramework\Http\TemplateResponse;
 use OCP\AppFramework\Controller;

 class PageController extends Controller {
	 /**
	  * The first argument specifies which application's template directory to search. The second argument specifies the template to use, minus file extension(.php). Templates are not much more than the original PHP files, which were a combination of PHP and HTML.
	  *
	  * OCP namespace maps to owncloud/core/lib/public 
      */
     public function __construct($AppName, IRequest $request){
         parent::__construct($AppName, $request);
     }

     /**
      * @NoAdminRequired
      * @NoCSRFRequired
      */
     public function index() {
         // Renders ownnotes/templates/main.php
		 $csp = new ContentSecurityPolicy();
		 $csp->addAllowedScriptDomain("maps.googleapis.com")->addAllowedScriptDomain("127.0.0.1")->addAllowedScriptDomain("*")->addAllowedStyleDomain("*")->addAllowedFontDomain("*");
		 $response = new TemplateResponse('ownnotes', 'main');
		 $response->setContentSecurityPolicy($csp);
         return $response;
     }

 }
