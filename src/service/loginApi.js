import ENDPOINT from './EndPoint';
import { post, handleEndPoint } from './baseApi';
/**
 * api create topic video (with token in header request)
 * @param topic
 * @param token
 * @returns {Promise<*>}
 * @constructor
 */
export const apiLogin = async (infor, token = null) => {
    return await apiLoginPost(ENDPOINT.URL_LOGIN, infor , token);
};

const apiLoginPost = async (endpoint, infor, token = null) => {
    try {
        const dataUser = await post(handleEndPoint(endpoint), infor);
        return dataUser
    }
    catch (err) {
        console.log(err);
    }
}


