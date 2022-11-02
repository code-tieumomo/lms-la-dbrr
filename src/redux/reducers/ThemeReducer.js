const ThemeReducer = (state = {}, action) => {
    switch(action.type) {
        case 'SET_MODE':
            return {
                ...state,
                mode: action.payload
            }
        case 'SET_COLOR':
            return {
                ...state,
                color: action.payload
            }
        case 'UPDATE_USER':
            return {
                ...state,
                profile: action.payload
            }
        default:
            return state
    }
}

export default ThemeReducer