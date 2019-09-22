<?php
namespace Core\Http;

interface ContentType
{
    // Multipart Related MIME 타입
    /*
    const MULTIPART_RELATED = "Multipart/related";
    const APPLICATION_XFIXEDRECORD = "Application/X-FixedRecord";
    */

    // XML Media 타입
    /*
    const TEXT_XML = "text/xml";
    const APPLICATION_XML = "Application/xml";
    const APPLICATION_XMLEXTERNALPARSEDENTITY = "Application/xml-external-parsed-entity";
    */

    /*
    Application/xml-dtd
    Application/mathtml+xml
    Application/xslt+xml
    */

    // Application 타입
    /*
    Application/EDI-X12
    Application/EDIFACT
    Application/javascript
    Application/octet-stream
    Application/ogg
    Application/x-shockwave-flash
    Application/json
    Application/x-www-form-urlencode

    */

    const APPLICATION_JSON = "application/json";

    
    


    // 오디오 타입
    /*
    audio/mpeg
    audio/x-ms-wma
    audio/vnd.rn-realaudio
    */

    //Multipart 타입
    /*
    multipart/mixed
    multipart/alternative
    multipart/related
    multipart/form-data
    */

    // text 타입
    /*
    test/css
    text/html
    text/javascript
    text/plain
    text/xml
    */

    // 파일타입
    /*
    application/msword
    applucation/pdf
    application/vnd.ms-excel
    application/x-javascript
    application/zip
    image/jpeg
    text/css
    text/html
    text/plain
    text/xml
    text/xsl
    */
}


