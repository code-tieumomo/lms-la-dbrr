import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    mode:'dark'
}

const themeSlice = createSlice({
    name: 'theme',
    initialState,
    reducers: {
        changeTheme(state, action) {
            
        },
        setColor(state, action) {

        }
    }
})

export default themeSlice