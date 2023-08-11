import Swal from "sweetalert2";
import {
    toast
} from "vue3-toastify";
import { Inertia } from "@inertiajs/inertia";
export default {
    async deleteIndexDialog(route,
        data, index) {

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                const loading = Swal.fire({
                    title: "Deleting...",
                    allowOutsideClick: false,
                    didOpen: async () => {
                        const response = await axios
                            .delete(
                                route
                            )
                            .then((response) => {
                                if (response.data.success) {
                                    toast.success(response.data.message);
                                    data.splice(index, 1);
                                } else {
                                    toast.error(response.data.message)
                                }
                            }).catch((error) => {
                                toast.error(error.message)
                            })
                            .finally(() => {
                                loading.close();
                            });
                        return response;
                    },
                });
                Swal.showLoading();
            }
        });
    },
    async changeStatus(route, params) {
        await axios
            .post(route, params)
            .then((response) => {
                if (response.data.success) {
                    toast.success(response.data.message)
                } else {
                    toast.error(response.data.message)
                }
            })
            .catch(function (error) {
                toast.error(error.message)
            });
    },
    async importFile(route, redirect_to = null, e) {
        const file = e.currentTarget.files[0];
        this.selectedFilename = file?.name;
        this.url = URL.createObjectURL(file);
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        const formData = new FormData();
        formData.append('file', file);
        return axios.post(route, formData, config)
            .then(function (response) {
                if (response.data.success) {
                    toast.success(response.data.message);
                    if (redirect_to) {
                        Inertia.get(
                            redirect_to,
                            {
                                preserveState: true,
                            }
                        );
                    }
                }
                else {
                    toast.error(response.data.message)
                }
            })
            .catch(function (error) {
                toast.error(error.message)
            });
    },
    async imageUpload(route, e, id) {

        const file = e.target.files[0];
        const formdata = new FormData();
        formdata.append("image", file);
        formdata.append("id", id);
        try {
            const response = await axios.post(route, formdata, { headers: { "Content-Type": "multipart/form-data", } });
            return {
                file: file,
                response: response.data,
            };
        } catch (error) {
            console.log("some error occured", error);
            return {
                file: file,
            }
        }
    },
    successToast(message) {
        toast.success(message);
    },
    errorToast(message) {
        toast.error(message);
    }
}