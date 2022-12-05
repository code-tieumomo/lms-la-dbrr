import { configureStore } from "@reduxjs/toolkit";
import themeSlice from "./reducers/themeSlice";
import profile from "./reducers/profileSlide";

export const store = configureStore({
    reducer: {
        profile: profile.reducer         
    },
})