import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import { useNavigate } from "react-router-dom";
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
    try {

        const res  = await apiLogin(value);
        localStorage.setItem('profile-mindx', JSON.stringify(res.data));
        localStorage.setItem('accessToken', JSON.stringify(res.data.idToken));
        toast.success("Đăng nhập thành công !!!!");
    }
    catch(err) {
        toast.error("Mời bạn nhập đúng tài khoản")
    }
})

export default profile;