/* eslint-disable import/no-unresolved */
/* eslint-disable react/jsx-key */
import { __ } from '@wordpress/i18n';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay, Keyboard, Mousewheel } from 'swiper';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/grid';
import {
	useBlockProps,
	InspectorControls,
	MediaPlaceholder,
	MediaUpload,
	MediaUploadCheck,
	BlockControls,
} from '@wordpress/block-editor';
import {
	PanelBody,
	ColorPalette,
	ToggleControl,
	SelectControl,
	ToolbarGroup,
	ToolbarButton,
	RangeControl,
	__experimentalUnitControl as UnitControl,
} from '@wordpress/components';
const { Fragment } = wp.element;

// editor style
import './editor.scss';

// colors
import colors from '../colors-palette';
import Devices from '../../components/devices';

export default function Edit({ attributes, setAttributes, clientId }) {
	const {
		sliderId,
		images,
		loop,
		speed,
		autoplay,
		reverseAutoplayDirection,
		autoplayDelay,
		pauseOnHover,
		keyboard,
		mousewheel,
		autoHeight,
		slideDirection,
		showNav,
		showPagination,
		itemDevice,
		deskItemsPerView,
		tabItemsPerView,
		phoneItemsPerView,
		spaceDevice,
		deskSpace,
		tabSpace,
		phoneSpace,
		showCaption,
		captionVisibility,
		captionBg,
		captionColor,
		borderWidth,
		borderColor,
		borderStyle,
		borderRadius,
		logoHoverStyle,
	} = attributes;

	// blcok id
	setAttributes({ sliderId: `alcb__${clientId.slice(0, 8)}` });

	return (
		<Fragment>
			{images && (
				<BlockControls>
					<ToolbarGroup>
						<MediaUploadCheck>
							<MediaUpload
								multiple={true}
								onSelect={(media) =>
									setAttributes({
										images: media,
									})
								}
								gallery={true}
								allowedTypes={['image']}
								value={images.map((logo) => logo.id)}
								render={({ open }) => {
									return (
										<ToolbarButton
											label={__(
												'Edit Logos',
												'n3-logo-carousel-block'
											)}
											onClick={open}
											icon="edit"
										/>
									);
								}}
							/>
						</MediaUploadCheck>
					</ToolbarGroup>
				</BlockControls>
			)}
			<InspectorControls>
				<PanelBody
					title={__(
						'Carousel Settings',
						'n3-logo-carousel-block'
					)}
					initialOpen={true}
				>
					<ToggleControl
						label={__(
							'Enable Autoplay',
							'n3-logo-carousel-block'
						)}
						checked={autoplay}
						onChange={() => setAttributes({ autoplay: !autoplay })}
					/>
					{autoplay && (
						<Fragment>
							<RangeControl
								label={__(
									'Autoplay Delay',
									'n3-logo-carousel-block'
								)}
								value={autoplayDelay}
								onChange={(autoplayDelay) =>
									setAttributes({ autoplayDelay })
								}
								min={100}
								max={10000}
								step={100}
							/>
							<ToggleControl
								label={__(
									'Pause Autoplay On Hover',
									'n3-logo-carousel-block'
								)}
								checked={pauseOnHover}
								onChange={() =>
									setAttributes({
										pauseOnHover: !pauseOnHover,
									})
								}
							/>
							<ToggleControl
								label={__(
									'Reserve Autoplay Direction',
									'n3-logo-carousel-block'
								)}
								checked={reverseAutoplayDirection}
								onChange={() =>
									setAttributes({
										reverseAutoplayDirection:
											!reverseAutoplayDirection,
									})
								}
							/>
						</Fragment>
					)}
					<SelectControl
						label={__(
							'Slide Direction',
							'n3-logo-carousel-block'
						)}
						value={slideDirection}
						options={[
							{
								label: __(
									'Left to Right',
									'n3-logo-carousel-block'
								),
								value: 'ltr',
							},
							{
								label: __(
									'Right to Left',
									'n3-logo-carousel-block'
								),
								value: 'rtl',
							},
						]}
						onChange={(slideDirection) => {
							setAttributes({ slideDirection });
						}}
					/>
					<RangeControl
						label={__(
							'Carousel Speed',
							'n3-logo-carousel-block'
						)}
						value={speed}
						onChange={(speed) => setAttributes({ speed })}
						min={100}
						max={2000}
						step={100}
					/>
					<ToggleControl
						label={__(
							'Enable Infinite Loop',
							'n3-logo-carousel-block'
						)}
						checked={loop}
						onChange={() => setAttributes({ loop: !loop })}
					/>
					<ToggleControl
						label={__(
							'Enable Auto Height',
							'n3-logo-carousel-block'
						)}
						checked={autoHeight}
						onChange={() =>
							setAttributes({ autoHeight: !autoHeight })
						}
					/>
					<ToggleControl
						label={__(
							'Enable Keyboard Control',
							'n3-logo-carousel-block'
						)}
						checked={keyboard}
						onChange={() => setAttributes({ keyboard: !keyboard })}
					/>
					<ToggleControl
						label={__(
							'Enable Mouse Control',
							'n3-logo-carousel-block'
						)}
						checked={mousewheel}
						onChange={() =>
							setAttributes({ mousewheel: !mousewheel })
						}
					/>
					{/* Items */}
					<Devices
						device={itemDevice}
						title={__(
							'Logos Per View',
							'n3-logo-carousel-block'
						)}
						renderFunction={(device) =>
							setAttributes({
								itemDevice: device,
							})
						}
					/>
					{itemDevice === 'desktop' && (
						<RangeControl
							value={deskItemsPerView}
							onChange={(deskItemsPerView) =>
								setAttributes({ deskItemsPerView })
							}
							min={1}
							max={10}
						/>
					)}

					{itemDevice === 'tablet' && (
						<RangeControl
							value={tabItemsPerView}
							onChange={(tabItemsPerView) =>
								setAttributes({ tabItemsPerView })
							}
							min={1}
							max={10}
						/>
					)}

					{itemDevice === 'smartphone' && (
						<RangeControl
							value={phoneItemsPerView}
							onChange={(phoneItemsPerView) =>
								setAttributes({ phoneItemsPerView })
							}
							min={1}
							max={10}
						/>
					)}

					{/* Space */}
					<Devices
						title={__(
							'Space Between Logos',
							'n3-logo-carousel-block'
						)}
						device={spaceDevice}
						renderFunction={(device) =>
							setAttributes({
								spaceDevice: device,
							})
						}
					/>
					{spaceDevice === 'desktop' && (
						<RangeControl
							value={deskSpace}
							onChange={(deskSpace) =>
								setAttributes({ deskSpace })
							}
							min={0}
							max={100}
						/>
					)}

					{spaceDevice === 'tablet' && (
						<RangeControl
							value={tabSpace}
							onChange={(tabSpace) => setAttributes({ tabSpace })}
							min={0}
							max={100}
						/>
					)}

					{spaceDevice === 'smartphone' && (
						<RangeControl
							value={phoneSpace}
							onChange={(phoneSpace) =>
								setAttributes({ phoneSpace })
							}
							min={0}
							max={100}
						/>
					)}
				</PanelBody>
				<PanelBody
					title={__('Navigation', 'n3-logo-carousel-block')}
					initialOpen={false}
				>
					<ToggleControl
						label={__(
							'Show Navigation',
							'n3-logo-carousel-block'
						)}
						help={
							showNav
								? __(
										'Navigation is Visible',
										'n3-logo-carousel-block'
								  )
								: __(
										'Navigation is invisible',
										'n3-logo-carousel-block'
								  )
						}
						checked={showNav}
						onChange={() =>
							setAttributes({
								showNav: !showNav,
							})
						}
					/>
				</PanelBody>

				<PanelBody
					title={__('Pagination', 'n3-logo-carousel-block')}
					initialOpen={false}
				>
					<ToggleControl
						label={__(
							'Show Pagination',
							'n3-logo-carousel-block'
						)}
						help={
							showPagination
								? __(
										'Pagination is Visible',
										'n3-logo-carousel-block'
								  )
								: __(
										'Pagination is invisible',
										'n3-logo-carousel-block'
								  )
						}
						checked={showPagination}
						onChange={() =>
							setAttributes({
								showPagination: !showPagination,
							})
						}
					/>
				</PanelBody>
				<PanelBody
					title={__('Logo Caption', 'n3-logo-carousel-block')}
					initialOpen={false}
				>
					<ToggleControl
						label={__(
							'Show Logo Caption',
							'n3-logo-carousel-block'
						)}
						checked={showCaption}
						onChange={() =>
							setAttributes({ showCaption: !showCaption })
						}
					/>
					{showCaption && (
						<Fragment>
							<SelectControl
								label={__(
									'Caption Visibility',
									'n3-logo-carousel-block'
								)}
								value={captionVisibility}
								options={[
									{
										label: __(
											'Always Visible',
											'n3-logo-carousel-block'
										),
										value: 'caption__always',
									},
									{
										label: __(
											'Visible on Hover',
											'n3-logo-carousel-block'
										),
										value: 'caption__hover',
									},
								]}
								onChange={(captionVisibility) => {
									setAttributes({ captionVisibility });
								}}
							/>
							<p className="alcb__label">
								{__('Color', 'n3-logo-carousel-block')}
							</p>
							<ColorPalette
								colors={colors}
								value={captionColor}
								onChange={(captionColor) =>
									setAttributes({ captionColor })
								}
							/>
							<p className="alcb__label">
								{__(
									'Background',
									'n3-logo-carousel-block'
								)}
							</p>
							<ColorPalette
								colors={colors}
								value={captionBg}
								onChange={(captionBg) =>
									setAttributes({ captionBg })
								}
							/>
						</Fragment>
					)}
				</PanelBody>
				<PanelBody
					title={__('Logo Style', 'n3-logo-carousel-block')}
					initialOpen={false}
				>
					<SelectControl
						label={__(
							'Logo Hover Style',
							'n3-logo-carousel-block'
						)}
						value={logoHoverStyle}
						options={[
							{
								label: __(
									'None',
									'n3-logo-carousel-block'
								),
								value: 'none',
							},
							{
								label: __(
									'GrayScale',
									'n3-logo-carousel-block'
								),
								value: 'normal_to_gray',
							},
							{
								label: __(
									'Zoom In',
									'n3-logo-carousel-block'
								),
								value: 'zoom_in',
							},
							{
								label: __(
									'Zoom Out',
									'n3-logo-carousel-block'
								),
								value: 'zoom_out',
							},
						]}
						onChange={(logoHoverStyle) => {
							setAttributes({ logoHoverStyle });
						}}
					/>
					<UnitControl
						label={__(
							'Border Width',
							'n3-logo-carousel-block'
						)}
						units={[]}
						onChange={(borderWidth) =>
							setAttributes({ borderWidth })
						}
						value={borderWidth}
						min={0}
					/>
					<br />
					{borderWidth !== '0px' && (
						<Fragment>
							<SelectControl
								label={__(
									'Border Style',
									'n3-logo-carousel-block'
								)}
								value={borderStyle}
								options={[
									{
										label: __(
											'Solid',
											'n3-logo-carousel-block'
										),
										value: 'solid',
									},
									{
										label: __(
											'Dotted',
											'n3-logo-carousel-block'
										),
										value: 'dotted',
									},
									{
										label: __(
											'Dashed',
											'n3-logo-carousel-block'
										),
										value: 'dashed',
									},
									{
										label: __(
											'Double',
											'n3-logo-carousel-block'
										),
										value: 'double',
									},
								]}
								onChange={(borderStyle) => {
									setAttributes({ borderStyle });
								}}
							/>
							<p className="alcb__label">
								{__(
									'Border Color',
									'n3-logo-carousel-block'
								)}
							</p>
							<ColorPalette
								colors={colors}
								value={borderColor}
								onChange={(borderColor) =>
									setAttributes({ borderColor })
								}
							/>
						</Fragment>
					)}
					<RangeControl
						label={__(
							'Border Radius',
							'n3-logo-carousel-block'
						)}
						value={borderRadius}
						onChange={(borderRadius) =>
							setAttributes({ borderRadius })
						}
						min={0}
						max={50}
					/>
				</PanelBody>
			</InspectorControls>

			<div
				{...useBlockProps({
					className: `${
						showPagination ? 'alcb__active_pagination' : ''
					}`,
				})}
			>
				<Swiper
					modules={[
						Navigation,
						Pagination,
						Autoplay,
						Keyboard,
						Mousewheel,
					]}
					spaceBetween={deskSpace}
					slidesPerView={deskItemsPerView}
					navigation={showNav}
					pagination={showPagination ? { clickable: true } : false}
					loop={loop}
					dir={slideDirection}
					autoplay={
						autoplay
							? {
									delay: autoplayDelay,
									disableOnInteraction: false,
									reverseDirection: reverseAutoplayDirection
										? true
										: false,
									pauseOnMouseEnter: pauseOnHover
										? true
										: false,
							  }
							: false
					}
					speed={speed}
					autoHeight={autoHeight}
					keyboard={keyboard ? { enabled: true } : false}
					mousewheel={mousewheel}
				>
					{images ? (
						images.map((logo) => {
							return (
								<SwiperSlide>
									<div
										className={`alcb__logo-item`}
										style={{
											border: ` ${borderWidth} ${borderStyle} ${borderColor}`,
											borderRadius: `${borderRadius}px`,
										}}
									>
										<div
											className={`alcb__logo-image  alcb__${logoHoverStyle}`}
										>
											<img
												src={logo.url}
												alt={logo.alt}
												id={logo.id}
											/>
										</div>
										{showCaption && (
											<div
												className={`alcb__logo-caption ${captionVisibility}`}
												style={{
													color: captionColor,
													backgroundColor: captionBg,
												}}
											>
												{logo.caption
													? logo.caption
													: __(
															'No Caption Available',
															'n3-logo-carousel-block'
													  )}
											</div>
										)}
									</div>
								</SwiperSlide>
							);
						})
					) : (
						<MediaPlaceholder
							multiple={true}
							onSelect={(media) =>
								setAttributes({
									images: media,
								})
							}
							onFilesPreUpload={(media) =>
								setAttributes({
									images: media,
								})
							}
							onSelectURL={false}
							allowedTypes={['image']}
							labels={{
								title: __(
									'Add Logos',
									'n3-logo-carousel-block'
								),
							}}
						/>
					)}
				</Swiper>
			</div>
		</Fragment>
	);
}
