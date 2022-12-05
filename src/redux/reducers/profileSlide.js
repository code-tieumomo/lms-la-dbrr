import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import { toast } from "react-toast";
import { apiLogin } from "../../service/loginApi";

const initialState = {
    status: '',
    profile: []
}

const profile = createSlice(
    {
        name: "profile",
        initialState,
        reducers: {
            fetchProfile (state, action) {
                state.push(action.payload);
            }
        },
        extraReducers: builder => {
            builder.addCase(fetchProfile.pending, (state, action) => {
               state.status = "loading...."
            }).addCase(fetchProfile.fulfilled, (state, action) => {
                state.profile = action.payload;
                state.status = "idle"
            })
        }
    }
) 

export const fetchProfile = createAsyncThunk ('profile/fetchProfile', async (value) => {
    const res  = await apiLogin(value);
    // const decoded = jwt_decode(response.data.idToken);
    console.log("res", res.data)
    localStorage.setItem('profile-mindx', JSON.stringify(res.data));
    localStorage.setItem('accessToken', JSON.stringify(res.data.idToken));
    toast.success("Đăng nhập thành công !!!!");
    // setTimeout(() => {
    //     history('/admin');
    // }, 1000);
    return res.data;
})

export default profile;