import axios from "axios";

//laravelEnvironment variable is from laravel views/home.blade.php

let baseApiUrl = 'http://127.0.0.1:8000';
if (appDataObj.appEnv === "remote") {
    baseApiUrl = 'https://icblog.42web.io';
}
export default axios.create({
    baseURL: baseApiUrl,
    withCredentials: true,
    headers: { 'Content-Type': 'application/json' }
});