import  { createSelector } from '@reduxjs/toolkit';

export const profileSelector = (state) => state.profile.profile
export const appSelector = createSelector(
    profileSelector
)