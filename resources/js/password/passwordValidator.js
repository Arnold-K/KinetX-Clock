
export default class PasswordValidator {
    async validate(_password) {
        return await new Promise((resolve, reject) => {
            if(_password.length < 8) {
                reject("Password must have 8 or more letters")
            }
            if(!_password.match(".*\\d.*")) {
                reject("Password must have at least a number")
            }
            if(!_password.match(".*[a-z].*")) {
                reject("Password must have at least a lowercase letter")
            }
            if(!_password.match(".*[A-Z].*")) {
                reject("Password must have at least an uppercase letter")
            }
            resolve()
        })
    }

    async passwordsMatch(_password, _confirmPassword) {
        return await new Promise( (resolve, reject) => {
            if(_password == _confirmPassword) resolve()
            reject("Passwords do not match!")
        } )
    }
}
