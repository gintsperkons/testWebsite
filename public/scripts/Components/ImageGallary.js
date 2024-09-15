class ImageGallary extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            images: props.images,
            selectedImage: props.images[0],
            selectedIndex: 0
        };

                this.handlePrevClick = this.handlePrevClick.bind(this);
                this.handleNextClick = this.handleNextClick.bind(this);
                this.handleThumbnailClick = this.handleThumbnailClick.bind(this);
    }
    render() {
        return (
            <div className="productGallery" data-testid='product-gallery'>
                <div className="thumbnailContainer">
                    {this.state.images.map((image, index) => (
                        <ThumbnailImage
                            key={index}
                            image={image}
                            isActive={this.state.selectedImage === image}
                            onClick={() => this.handleThumbnailClick(image)}
                        />
                    ))}
                </div>
                <div className="mainImageWrapper">
                    <button className="arrow leftArrow" onClick={this.handlePrevClick}>
                        &#8249;
                    </button>
                    <MainImage image={this.state.images[this.state.selectedIndex]} />
                    <button className="arrow rightArrow" onClick={this.handleNextClick}>
                        &#8250;
                    </button>
                </div>
            </div>
        );
    }

    handlePrevClick() {
        console.log(this);
        this.state.selectedIndex;
        this.state.images.length;
        this.state.selectedIndex;
        const newIndex = this.state.selectedIndex === 0 ? this.state.images.length - 1 : this.state.selectedIndex - 1;
        this.setState({
            selectedImage: this.state.images[newIndex],
            selectedIndex: newIndex
        });
    }

    handleNextClick() {
        const newIndex = this.state.selectedIndex === this.state.images.length - 1 ? 0 : this.state.selectedIndex + 1;
        this.setState({
            selectedImage: this.state.images[newIndex],
            selectedIndex: newIndex
        });
    }
    handleThumbnailClick(image) {
        console.log(this);
        this.setState({
            selectedImage: image,
            selectedIndex: this.state.images.indexOf(image)
        });
    }
}

window.ImageGallary = ImageGallary;