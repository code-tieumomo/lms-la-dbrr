const setMode = mode => {
    return {
        type: 'SET_MODE',
        payload: mode
    }
}

const setColor = color => {
    return {
        type: 'SET_COLOR',
        payload: color
    }
}

const updateUser = user => {
    return {
        type: 'UPDATE_USER',
        payload: user
    }
}

const getTheme = () => {
    return {
        type: 'GET_THEME'
    }
}

const exportDefault = {
    setColor,
    setMode,
    getTheme,
    updateUser
}

export default exportDefault