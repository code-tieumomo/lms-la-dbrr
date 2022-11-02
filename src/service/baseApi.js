import axios from 'axios';
/**
 * create axios
 * @type {AxiosInstance}
 */
const instance = axios.create({
    baseUrl: process.env.REACT_APP_BASE_URL,
    headers: {
        'Content-Type': 'application/json'
    },
    timeout: 5000,
})

/**
 * method post
 * @param url
 * @param data
 * @returns {Promise<AxiosResponse<any>>}
 */
export const post = async (url, data) => {
	return await instance.post(url, data);
};

export const get = async (url, data) => {
	let urlGet = url + '?' + new URLSearchParams(data);
	return await instance.get(urlGet);
};

export const handleEndPoint = (url) => {
    return process.env.REACT_APP_BASE_URL + url;
}