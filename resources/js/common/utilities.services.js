export const generateShortUUID = () => {
    return 'xxxxxxxx'.replace(/[xy]/g, (c) => {
        let r = Math.random() * 12 | 0,
            v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(12);
    });
 };

export const  generateOrderNumber = () => {
    let now = Date.now().toString() // '1492341545873'
    // pad with extra random digit
    now += now + Math.floor(Math.random() * 10)
    // format
    return  [now.slice(0, 4), now.slice(4,10)].join('')
}