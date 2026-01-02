# Upload Image Feature Implementation

## Overview
Portfolio images can now be uploaded in two ways:
1. **Upload File** - Upload image files directly from your device (JPG, PNG, GIF, WebP up to 5MB)
2. **From URL** - Paste the image URL from an external source

## Features Implemented

### 1. Create Portfolio Page (`resources/views/portfolio/create.blade.php`)
- **Radio Button Toggle**: Choose between "Upload File" or "From URL"
- **File Upload Input**: Accept image files with drag-and-drop support
- **Live Image Preview**: See the selected image before uploading
- **File Validation**: 
  - Max size: 5MB
  - Formats: JPG, PNG, GIF, WebP
  - Real-time validation feedback
- **URL Input**: Alternative option to use image URLs
- **Form Encoding**: Added `enctype="multipart/form-data"` for file uploads

### 2. Edit Portfolio Page (`resources/views/portfolio/edit.blade.php`)
- **Same functionality as create page**
- **Current Image Display**: Shows the currently uploaded image when editing
- **Easy Switching**: Switch between file upload and URL input without losing data
- **Form Encoding**: Added `enctype="multipart/form-data"` for file uploads

### 3. Portfolio Controller (`app/Http/Controllers/PortfolioController.php`)
**Already implemented and working:**
- **store() method**: Handles both file upload and URL submission
- **update() method**: Supports changing image type and file replacement
- **File Storage**: Uses Laravel Storage facade with 'public' disk
- **Automatic Cleanup**: Deletes old files when portfolio is deleted (via Model events)
- **Validation**: 
  - `image_file`: image|mimes:jpeg,png,jpg,gif,webp|max:5120
  - `image_url`: url
  - `image_type`: required|in:uploaded,url

### 4. Portfolio Model (`app/Models/Portfolio.php`)
**Already has necessary attributes:**
- `image_type` - Enum: 'uploaded' or 'url'
- `image_path` - Path to uploaded file in storage
- `image_url` - URL to image (either uploaded or external)
- `getImageAttribute()` - Returns correct image URL based on type
- `boot()` event - Auto-deletes files on portfolio deletion

## JavaScript Features

### Image Type Toggle
```javascript
// Switches between upload file section and URL input section
// Radio button controls visibility
```

### Live Image Preview
```javascript
// Shows selected file with:
// - Image thumbnail
// - File name
// - File size in KB
// - Success icon
// - Validation feedback
```

### File Validation
```javascript
// Validates before upload:
// - Maximum 5MB file size
// - Displays error if exceeded
// - Clears invalid selection
```

### URL Validation
```javascript
// Validates URL format:
// - Must be valid URL
// - Should end with image extension
// - Real-time feedback
```

## Usage Flow

### Creating New Portfolio with File Upload
1. Go to "Buat Portfolio Baru" (Create New Portfolio)
2. Fill in project details
3. Scroll to "Gambar Proyek" (Project Image) section
4. Select **"Upload File"** radio button
5. Click file input to browse and select image
6. Preview appears automatically
7. Click "Publikasikan Portfolio" to save

### Creating Portfolio with URL
1. Fill in project details
2. Select **"Dari URL"** (From URL) radio button
3. Paste image URL
4. Click "Publikasikan Portfolio" to save

### Editing Portfolio
1. Go to edit portfolio page
2. Toggle between upload type using radio buttons
3. Switch to new image or URL
4. Click "Simpan Perubahan" (Save Changes)

## Storage Information

### File Location
- **Disk**: Laravel public disk
- **Directory**: `/storage/app/public/portfolios/`
- **Access URL**: `/storage/portfolios/{filename}`
- **Symlink**: Must have `php artisan storage:link` executed

### File Management
- Files are stored with unique names (timestamp-based)
- Old files are automatically deleted when:
  - Portfolio is deleted
  - Image type is changed from uploaded to URL
  - New file is uploaded (old replaced)

## Validation Rules

| Field | Rules | Message |
|-------|-------|---------|
| image_type | required\|in:uploaded,url | Must choose upload type |
| image_file | nullable\|image\|mimes:jpeg,png,jpg,gif,webp\|max:5120 | File must be image, max 5MB |
| image_url | nullable\|url | URL format invalid |

## Error Handling

### File Upload Errors
- **Size exceeds 5MB**: Display alert and clear selection
- **Invalid format**: Show validation message
- **Missing file**: Redirect with error for uploaded type

### URL Errors
- **Invalid format**: Show validation message
- **Missing URL**: Redirect with error for URL type

## Browser Compatibility
- File input: All modern browsers
- File preview: Chrome 11+, Firefox 4+, Safari 5.1+, Edge 12+
- Drag-and-drop: All modern browsers

## Security Measures
- File type validation (MIME types)
- File size limitation (5MB max)
- Storage outside public root (Laravel public disk)
- Automatic file cleanup on deletion
- Validation on both client and server side

## Future Enhancements
- Drag-and-drop file upload
- Image cropping/resizing
- Batch upload
- CDN integration
- Image optimization
- Lazy loading implementation

## Testing Checklist
- [ ] Upload small image (< 1MB)
- [ ] Upload medium image (2-3MB)
- [ ] Upload max size image (4.9MB)
- [ ] Try uploading oversized file (> 5MB)
- [ ] Switch between upload/URL without losing data
- [ ] Edit portfolio and change image type
- [ ] Delete portfolio and verify file cleanup
- [ ] Use external image URL
- [ ] Test on mobile devices
- [ ] Test with slow internet connection
