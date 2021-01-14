<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Integrations\shep\sender\ShepRequestSender;
use App\Integrations\shep\receiver\ServiceRequestRouter;

class IntegrationController extends Controller
{
    public function index($type)
    {
        $response = array();
        switch ($type) {
            case 'shep':
                if (isset($_GET['service'])) {
                    $response = ShepRequestSender::send($_GET['service'], $_GET);
                } else {
                    echo 'no service found';
                }
                break;
            default:
                echo 'no integration found';
                break;
        }
        print_r($response);
        exit;
    }

    public function test()
    {
        $response = array();
        $response['egkn_receive_status'] = ShepRequestSender::send('egkn_receive_status', $_GET);
        $response['egkn_receive_order'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        $response['geoportal_egkn_receive_layer'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        $response['egkn_geoportal_actualization'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        $response['eds_temp_files'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        $response['geoportal_pep_async'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        $response['ais_gzk_get_data'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        $response['ais_gzk_get_relevance'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        return view('test')->with('data', $response);
    }

    public function prettyXml(){
        $xml = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://bip.bee.kz/AsyncChannel/v10/Types"><soapenv:Header xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" soapenv:mustUnderstand="1"><ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="SIG-89B96E14377C3A44E2161060010050223455"><ds:SignedInfo><ds:CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/><ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#gost34310-gost34311"/><ds:Reference URI="#id-89B96E14377C3A44E2161060010050223454"><ds:Transforms><ds:Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/></ds:Transforms><ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#gost34311"/><ds:DigestValue>8RqYmVwUsH/+3hzD4+USx+fAs4HvctrcKnqrZmUOlWM=</ds:DigestValue></ds:Reference></ds:SignedInfo><ds:SignatureValue>2lYfz1Hx/qzvxWMn6bt+m89rGwAuWKF4+/TV1WgF42K3uyk8BEMX25A8J2XZQZJH/Zh37tFx/Few6540v/v6xA==</ds:SignatureValue><ds:KeyInfo Id="KI-89B96E14377C3A44E2161060010050123452"><wsse:SecurityTokenReference wsu:Id="STR-89B96E14377C3A44E2161060010050123453"><ds:X509Data><ds:X509IssuerSerial><ds:X509IssuerName>CN=ҰЛТТЫҚ КУӘЛАНДЫРУШЫ ОРТАЛЫҚ (GOST),C=KZ</ds:X509IssuerName><ds:X509SerialNumber>417157195680026735073120748251296757333772328683</ds:X509SerialNumber></ds:X509IssuerSerial></ds:X509Data></wsse:SecurityTokenReference></ds:KeyInfo></ds:Signature></wsse:Security></soapenv:Header><soap:Body xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" wsu:Id="id-89B96E14377C3A44E2161060010050223454"> <typ:sendMessageResponse> <response> <messageId>212198064</messageId> <correlationId>3204633</correlationId> <responseDate>2021-01-14T10:54:39.376+06:00</responseDate> <sessionId>{f2632129-2406-4736-93ae-cd4eb6c9fb5f}</sessionId> </response> </typ:sendMessageResponse></soap:Body> </soap:Envelope>';
        XmlDocument xml = new \XmlDocument();
        xml.LoadXml($xml); // suppose that myXmlString contains "<Names>...</Names>"

        XmlNodeList xnList = xml.SelectNodes("/Names/Name");
        foreach (XmlNode xn in xnList)
        {
          string firstName = xn["FirstName"].InnerText;
          string lastName = xn["LastName"].InnerText;
          Console.WriteLine("Name: {0} {1}", firstName, lastName);
        }
        return ;
    }

    public function receive(Request $request)
    {
        ServiceRequestRouter::route($request);
    }

    public function sync(Request $request)
    {
        return true;
    }

    public function async(Request $request)
    {
        return true;
    }
}
