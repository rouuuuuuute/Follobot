<?php

namespace App\Services;

class AccessTokenService{
    //プロパティ
    public $api_key;
    public $api_secret;
    public $callback_url;
    public $request_token_secret;
    public $request_url;
    public $request_method;

    public function __construct($api_key, $api_secret, $callback_url,$request_token_secret,$request_url,$request_method){
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->callback_url = $callback_url;
        $this->request_token_secret =$request_token_secret;
        $this->request_url = $request_url;
        $this->request_method = $request_method;
    }


    public function request()
    {
        // キーを作成する
        $signature_key = rawurlencode($this->api_secret) . "&" . rawurlencode($this->request_token_secret);

        // パラメータ([oauth_signature]を除く)を連想配列で指定
        $params = array(
            "oauth_consumer_key" => $this->api_key,
            "oauth_token" => $_GET["oauth_token"],
            "oauth_signature_method" => "HMAC-SHA1",
            "oauth_timestamp" => time(),
            "oauth_verifier" => $_GET["oauth_verifier"],
            "oauth_nonce" => microtime(),
            "oauth_version" => "1.0",
        );

        // 配列の各パラメータの値をURLエンコード
        foreach ($params as $key => $value) {
            $params[$key] = rawurlencode($value);
        }

        // 連想配列をアルファベット順に並び替え
        ksort($params);

        // パラメータの連想配列を[キー=値&キー=値...]の文字列に変換
        $request_params = http_build_query($params, "", "&");

        // 変換した文字列をURLエンコードする
        $request_params = rawurlencode($request_params);

        // リクエストメソッドをURLエンコードする
        $encoded_request_method = rawurlencode($this->request_method);

        // リクエストURLをURLエンコードする
        $encoded_request_url = rawurlencode($this->request_url);

        // リクエストメソッド、リクエストURL、パラメータを[&]で繋ぐ
        $signature_data = $encoded_request_method . "&" . $encoded_request_url . "&" . $request_params;

        // キー[$signature_key]とデータ[$signature_data]を利用して、HMAC-SHA1方式のハッシュ値に変換する
        $hash = hash_hmac("sha1", $signature_data, $signature_key, TRUE);

        // base64エンコードして、署名[$signature]が完成する
        $signature = base64_encode($hash);

        // パラメータの連想配列、[$params]に、作成した署名を加える
        $params["oauth_signature"] = $signature;

        // パラメータの連想配列を[キー=値,キー=値,...]の文字列に変換する
        $header_params = http_build_query($params, "", ",");

        // リクエスト用のコンテキストを作成する
        $context = array(
            "http" => array(
                "method" => $this->request_method,    //リクエストメソッド
                "header" => array(    //カスタムヘッダー
                    "Authorization: OAuth " . $header_params,
                ),
            ),
        );

        // cURLを使ってリクエスト
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->request_url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $context["http"]["method"]);    // メソッド
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);    // 証明書の検証を行わない
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    // curl_execの結果を文字列で返す
        curl_setopt($curl, CURLOPT_HTTPHEADER, $context["http"]["header"]);    // ヘッダー
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);    // タイムアウトの秒数
        $res1 = curl_exec($curl);
        $res2 = curl_getinfo($curl);
        curl_close($curl);

        // 取得したデータ
        $response = substr($res1, $res2["header_size"]);    // 取得したデータ(JSONなど)

        // $responseの内容(文字列)を$query(配列)に直す
        $query = [];
        parse_str($response, $query);

        return $query;



    }
    }
