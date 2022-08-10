export default (fileSize: number): string => {
    if (fileSize < 1000) {
        return `${Math.round(fileSize)} B`
    }

    if (fileSize >= 1000 && fileSize < 1000000) {
        return `${Math.round(fileSize / 1000)} KB`
    }

    return `${(fileSize / 1000000).toFixed(1)} MB`
}