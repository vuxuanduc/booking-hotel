// ./auth/userinfo.email
// ./auth/userinfo.profile

const clientId = "296723434721-d1frh1evsgjg83726oku0n204c8ejinp.apps.googleusercontent.com" ;
const LINK_GET_TOKEN = `https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/userinfo.email%20https://www.googleapis.com/auth/userinfo.profile&response_type=token&redirect_uri=https%3A//oauth2.example.com/code&client_id=${clientId}` ;