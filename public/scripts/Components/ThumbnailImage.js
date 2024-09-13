class ThumbnailImage extends React.Component {
  render() {
    const { image, isActive, onClick } = this.props;
    return (
      <img
        src={image}
        className={`thumbnailImage ${isActive ? 'active' : ''}`}
        onClick={onClick}
      />
    );
  }
}

window.ThumbnailImage = ThumbnailImage;