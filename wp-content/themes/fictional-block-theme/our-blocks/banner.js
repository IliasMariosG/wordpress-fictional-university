import { apiFetch } from '@wordpress/api-fetch'
import { InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor'
import { Button, PanelBody, PanelRow } from '@wordpress/components'
import { useEffect } from '@wordpress/elements'

wp.blocks.registerBlockType("ourblocktheme/banner", {
  title: "Banner",
  supports: {
    align: ["full"]
  },
  attributes: {
    align: {type: "string", default: "full"},
    imageID: {type: "number"},
    imageURL: {type: "string", default: window.banner.fallbackimage}
  },
  edit: EditComponent,
  save: SaveComponent
})

function EditComponent(props) {
  useEffect(function() {
    if (props.attributes.imageID) {
      async function go() {
        const response = await apiFetch({
          path: `/wp/v2/media/${props.attributes.imageID}`,
          method: 'GET'
        })
        props.setAttributes({imageURL: response.media_details.sizes.pageBanner.source_url})
      }
      go()
    }
  }, [props.attributes.imageID])

  function onFileSelect(x) {
    props.setAttributes({imageID: x.ID})
  }
  return (
    <>
      <InspectorControls>
        <PanelBody title="background" initialOpen={true}>
          <PanelRow>
            <MediaUploadCheck>
              <MediaUpload onSelect={onFileSelect} value={props.attributes.imageID} render={({ open }) => {
                return <Button onClick={open}>Choose image</Button>
              }}/>
            </MediaUploadCheck>
          </PanelRow>
        </PanelBody>
      </InspectorControls>
      <div className="page-banner">
      <div className="page-banner__bg-image" style={{backgroundImage: `url('${props.attributes.imageURL}')`}}></div>
      <div className="page-banner__content container t-center c-white">
        <InnerBlocks allowedBlocks={['ourblocktheme/genericheading', 'ourblocktheme/genericbutton']} />
      </div>
    </div>
    </>
  )
}

function SaveComponent(params) {
  return <InnerBlocks.Content />
}