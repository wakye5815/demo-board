import Axios, { AxiosInstance, AxiosPromise } from "axios"
import store from "../store"
import { ApiResponse } from './types'
import router from "../router";

class HttpClient {
    private axios!: AxiosInstance
    constructor() {
        this.axios = Axios.create({
            headers: {
                'X-XSRF-TOKEN': document.cookie.split(';')
                    .find(cookie => cookie.split('=')[0] == 'XSRF-TOKEN')!
                    .replace(/.*=/, ""),
                'X-Requested-With': 'XMLHttpRequest'
            },
            timeout: 180000
        })
    }

    public async get(url: string, paramObj: object = {}) {
        return this.processAxiosPromise(
            this.axios.get<ApiResponse<any>>(url, this.toQueryParams(paramObj))
        );
    }

    public async post(url: string, paramObj: object) {
        return this.processAxiosPromise(
            this.axios.post<ApiResponse<any>>(url, this.toURLSearchParams(paramObj))
        );
    }

    public async patch(url: string, paramObj: object) {
        return this.processAxiosPromise(
            this.axios.patch<ApiResponse<any>>(url, this.toURLSearchParams(paramObj))
        );
    }

    public async delete(url: string, paramObj: object) {
        return this.processAxiosPromise(
            this.axios.delete(url, this.toQueryParams(paramObj))
        );
    }

    // APIリクエスト時の共通処理
    private async processAxiosPromise<T>(promise: AxiosPromise<T>) {
        store.commit("isLoading", true);
        const response = await promise
            .catch(err => {
                router.push("/error");
                throw new Error("system error");
            })
            .finally(() => store.commit("isLoading", false));
        return response.data
    }

    private toURLSearchParams(paramObj: object) {
        const params = new URLSearchParams()
        Object.keys(paramObj)
            .forEach(key => params.append(key, (paramObj as any)[key].toString()));
        return params;
    }

    private toQueryParams(paramObj: object) {
        return { params: paramObj };
    }
}

export default new HttpClient();